<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ConfigurableRequest;

use App\Models\Configurable;
use App\Models\Field;

use Response;
use Auth;
use Session;
use Lang;
/**
 * Contains configurables resources  
 * 
 */
class ConfigurableController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //List all configurables
        $configurables = Configurable::orderBy('name', 'ASC')->get();
        //Load the view and pass the configurables
        return view('config.configurable.index', compact('configurables'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create Configurable
        return view('config.configurable.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ConfigurableRequest $request)
    {
        $configurable = new Configurable;
        $configurable->name = $request->name;
        $configurable->description = $request->description;
        $configurable->user_id = 1;
        $configurable->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_configurable', $configurable ->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //show a Configurable
        $configurable = Configurable::find($id);
        //show the view and pass the $configurable to it
        return view('config.configurable.show', compact('configurable'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $fields = Field::orderBy('field_name')->get();
        //Get the Configurable
        $configurable = Configurable::find($id);

        //Open the Edit View and pass to it the $configurable
        return view('config.configurable.edit', compact('configurable', 'fields'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ConfigurableRequest $request, $id)
    {
        $configurable = Configurable::find($id);
        $configurable->name = $request->name;
        $configurable->description = $request->description;
        $configurable->user_id = 1;
        $configurable->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_configurable', $configurable ->id);
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
        //Soft delete the Configurable
        $configurable = Configurable::find($id);

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