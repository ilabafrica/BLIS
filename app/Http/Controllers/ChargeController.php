<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ChargeRequest;
use App\Models\Charge;

/**
 * Contains Charges Resource  
 * 
 */
class ChargeController extends Controller {

    /**
     * Display a listing of all charges by the laboratory.
     *
     * @return Response
     */
    public function index()
    {
        //List all Charges
        $charges = Charge::orderBy('name', 'ASC')->get();
        //Load the view and pass the Charges
        return view('billing.charge.index', compact('charges'));
    }


    /**
     * Show the form for creating a new charge.
     *
     * @return Response
     */
    public function create()
    {
        //Create Charge
        return view('billing.charge.create');
    }


    /**
     * Store a newly created charge in storage.
     *
     * @return Response
     */
    public function store(ChargeRequest $request)
    {
        $charge = new Charge;
        $charge->test_id = $request->test_id;
        $charge->current_amount = $request->current_amount;
        $charge->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)
        	->with('message', trans('terms.record-successfully-saved'))
        	->with('active_charge', $charge ->id);
    }


    /**
     * Display the specified charge.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //show a Charge
        $charge = Charge::find($id);
        //show the view and pass the $charge to it
        return view('billing.charge.show', compact('charge'));
    }


    /**
     * Show the form for editing the specified charge.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the Charge
        $charge = Charge::find($id);

        //Open the Edit View and pass to it the $charge
        return view('billing.charge.edit', compact('charge'));
    }


    /**
     * Update the specified charge in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ChargeRequest $request, $id)
    {
        $charge = Charge::find($id);
        $charge->test_id = $request->test_id;
        $charge->current_amount = $request->current_amount;
        $charge->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)
        	->with('message', trans('terms.record-successfully-saved'))
        	->with('active_charge', $charge ->id);
    }


    /**
     * Remove the specified charge from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $charge = Charge::find($id);
        $url = session('SOURCE_URL');

        return redirect()->to($url)
        	->with('message', trans('terms.record-successfully-deleted'));
    }
}
