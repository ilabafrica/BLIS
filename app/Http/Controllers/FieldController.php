<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\FieldRequest;

use App\Models\Field;

use Response;
use Auth;
use Session;
use Lang;
/**
 * Contains Fields resources  
 * 
 */
class FieldController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //List all Fields
        $fields = Field::orderBy('name', 'ASC')->get();
        //Load the view and pass the Fields
        return view('config.field.index', compact('fields'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create Field
        return view('config.field.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(FieldRequest $request)
    {
        $field = new Field;
        $field->name = $request->name;
        $field->description = $request->description;
        $field->user_id = 1;
        $field->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_field', $field ->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //show a Field
        $field = Field::find($id);
        //show the view and pass the $field to it
        return view('config.field.show', compact('field'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the Field
        $field = Field::find($id);

        //Open the Edit View and pass to it the $field
        return view('config.field.edit', compact('field'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(FieldRequest $request, $id)
    {
        $field = Field::find($id);
        $field->name = $request->name;
        $field->description = $request->description;
        $field->user_id = 1;
        $field->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_field', $field ->id);
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
        //Soft delete the Field
        $field = Field::find($id);

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