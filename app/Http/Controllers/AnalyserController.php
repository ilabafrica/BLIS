<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\AnalyserRequest;

use App\Models\Analyser;
use App\Models\TestCategory;
use App\Models\Configurable;
use App\Models\Field;
use App\Models\ConField;

use Response;
use Auth;
use Session;
use Lang;
/**
 * Contains analysers resources  
 * 
 */
class AnalyserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //List all analysers
        $analysers = Analyser::orderBy('name', 'ASC')->get();
        //Load the view and pass the analysers
        return view('config.analyser.index', compact('analysers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get lab sections
        $testcategories = TestCategory::lists('name', 'id');
        // Feed-sources RS232,TCP/IP, MSACCESS,HTTP,TEXT
        $feedsources = [Analyser::RS232 => 'RS232', Analyser::TCPIP => 'TCP/IP', Analyser::MSACCESS => 'MSACCESS', Analyser::HTTP => 'HTTP', Analyser::TEXT => 'TEXT'];
        // Communication-types
        $commtypes = [Analyser::UNIDIRECTIONAL => 'Uni-directional', Analyser::BIDIRECTIONAL => 'Bi-directional'];
        //Create Analyser
        return view('config.analyser.create', compact('testcategories', 'feedsources', 'commtypes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AnalyserRequest $request)
    {
        $analyser = new Analyser;
        $analyser->name = $request->name;
        $analyser->version = $request->version;
        $analyser->test_category_id = $request->test_category_id;
        $analyser->comm_type = $request->comm_type;
        $analyser->feed_source = $request->feed_source;
        $analyser->config_file = $request->config_file;
        $analyser->description = $request->description;
        $analyser->user_id = 1;
        $analyser->save();
        /* Save the analyser name to configurables */
        $configurable = new Configurable;
        $configurable->name = $analyser->name;
        $configurable->user_id = 1;
        $configurable->save();
        /* Save configurable-fields for the configurable RS232,TCP/IP, MSACCESS,HTTP,TEXT */
        $fields = [];
        if($analyser->feed_source == Analyser::RS232)
            $fields = Field::RS232;
        else if($analyser->feed_source == Analyser::TCPIP)
            $fields = Field::TCPIP;
        else if($analyser->feed_source == Analyser::MSACCESS)
            $fields = Field::MSACCESS;
        else if($analyser->feed_source == Analyser::TEXT)
            $fields = Field::TEXT;
        foreach ($fields as $field)
        {
            $fId = Field::idByName($field);
            $conf = ConField::where('configurable_id', $configurable->id)->where('field_id', $fId)->first();
            if($conf)
                $conField = ConField::find($conf->id);
            else
                $conField = new ConField;
            $conField->configurable_id = $configurable->id;
            $conField->field_id = $fId;
            $conField->user_id = 1;
            $conField->save();
        }
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_analyser', $analyser ->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //show a Analyser
        $analyser = Analyser::find($id);
        //show the view and pass the $analyser to it
        return view('config.analyser.show', compact('analyser'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the Analyser
        $analyser = Analyser::find($id);
        // Get lab sections
        $testcategories = TestCategory::lists('name', 'id');
        // Get selected category
        $testcategory = $analyser->test_category_id;
        // Feed-sources RS232,TCP/IP, MSACCESS,HTTP,TEXT
        $feedsources = [Analyser::RS232 => 'RS232', Analyser::TCPIP => 'TCP/IP', Analyser::MSACCESS => 'MSACCESS', Analyser::HTTP => 'HTTP', Analyser::TEXT => 'TEXT'];
        // selected source
        $feedsource = $analyser->feed_source;
        // Communication-types
        $commtypes = [Analyser::UNIDIRECTIONAL => 'Uni-directional', Analyser::BIDIRECTIONAL => 'Bi-directional'];
        // selected comm-type
        $commtype = $analyser->commtype;
        //Open the Edit View and pass to it the $analyser
        return view('config.analyser.edit', compact('analyser', 'testcategories', 'testcategory', 'feedsources', 'feedsource', 'commtypes', 'commtype'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(AnalyserRequest $request, $id)
    {
        $analyser = Analyser::find($id);
        $analyser->name = $request->name;
        $analyser->version = $request->version;
        $analyser->test_category_id = $request->test_category_id;
        $analyser->comm_type = $request->comm_type;
        $analyser->feed_source = $request->feed_source;
        $analyser->config_file = $request->config_file;
        $analyser->description = $request->description;
        $analyser->user_id = 1;
        $analyser->save();
        //dd(Configurable::idByName($analyser->name));
        /* Proceed to update the corresponding equipment */
        if(count(Configurable::where('name', $analyser->name)->get())>0)
            $configurable = Configurable::where('name', $analyser->name)->first();
        else
            $configurable = new Configurable;
        $configurable->name = $analyser->name;
        $configurable->user_id = 1;
        $configurable->save();
        /* Save configurable-fields for the configurable RS232,TCP/IP, MSACCESS,HTTP,TEXT */
        $fields = [];
        if($analyser->feed_source == Analyser::RS232)
            $fields = Field::RS232;
        else if($analyser->feed_source == Analyser::TCPIP)
            $fields = Field::TCPIP;
        else if($analyser->feed_source == Analyser::MSACCESS)
            $fields = Field::MSACCESS;
        else if($analyser->feed_source == Analyser::TEXT)
            $fields = Field::TEXT;
        foreach ($fields as $field)
        {
            $fId = Field::idByName($field);
            $conf = ConField::where('configurable_id', $configurable->id)->where('field_id', $fId)->first();
            if($conf)
                $conField = ConField::find($conf->id);
            else
                $conField = new ConField;
            $conField->configurable_id = $configurable->id;
            $conField->field_id = $fId;
            $conField->user_id = 1;
            $conField->save();
        }
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_analyser', $analyser ->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //Soft delete the Analyser
        $analyser = Analyser::find($id);

        /*$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
        if (empty($testCategoryInUse)) {
            // The test category is not in use
            $testcategory->delete();
        } else {
            // The test category is in use
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
                ->with('message', trans('general-terms.failure-test-category-in-use'));
        }*/
        // redirect
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-deleted'));
    }
}