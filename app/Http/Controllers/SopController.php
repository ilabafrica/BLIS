<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SopRequest;
use App\Models\Sop;
use Response;
use Auth;
use Session;
use Lang;
/**
 * Contains sops resources  
 * 
 */
class SopController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //List all sops
        $sops = Sop::orderBy('name', 'ASC')->get();
        //Load the view and pass the sops
        return view('sop.index', compact('sops'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create sop
        return view('sop.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SopRequest $request)
    {
        // dd('we in');
        $sop = new Sop;
        $sop->name = $request->name;
        $sop->description = $request->description;
        $sop->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_sop', $sop ->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //show a sop
        $sop = Sop::find($id);
        //show the view and pass the $sop to it
        return view('sop.show', compact('sop'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the sop
        $sop = Sop::find($id);

        //Open the Edit View and pass to it the $sop
        return view('sop.edit', compact('sop'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(SopRequest $request, $id)
    {
        $sop = Sop::find($id);
        $sop->name = $request->name;
        $sop->description = $request->description;
        $sop->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_sop', $sop ->id);
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
        //Soft delete the sop
        $sop = Sop::find($id);

        /*$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
        if (empty($testCategoryInUse)) {
            // The test category is not in use
            $testcategory->delete();
        } else {
            // The test category is in use
            $url = session('SOURCE_URL');
            
            return Redirect::to($url)
                ->with('message', trans('terms.failure-test-category-in-use'));
        }*/
        // redirect
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-deleted'));
    }
}