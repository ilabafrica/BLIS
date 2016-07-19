<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

/**
 * Contains Payments Resource  
 * 
 */
class PaymentController extends Controller {

    /**
     * Display a listing of all payments by the laboratory.
     *
     * @return Response
     */
    public function index()
    {
        //List all Payments
        $payments = Payment::orderBy('name', 'ASC')->get();
        //Load the view and pass the Payments
        return view('billing.payment.index', compact('payments'));
    }


    /**
     * Show the form for creating a new payment.
     *
     * @return Response
     */
    public function create()
    {
        //Create Payment
        return view('billing.payment.create');
    }


    /**
     * Store a newly created payment in storage.
     *
     * @return Response
     */
    public function store(PaymentRequest $request)
    {
        $payment = new Payment;
        $payment->patient_id = $request->patient_id;
        $payment->charge_id = $request->charge_id;
        $payment->full_amount = $request->full_amount;
        $payment->amount_paid = $request->amount_paid;
        $payment->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)
        	->with('message', trans('terms.record-successfully-saved'))
        	->with('active_payment', $payment ->id);
    }


    /**
     * Display the specified payment.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //show a Payment
        $payment = Payment::find($id);
        //show the view and pass the $payment to it
        return view('billing.payment.show', compact('payment'));
    }


    /**
     * Show the form for editing the specified payment.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the Payment
        $payment = Payment::find($id);

        //Open the Edit View and pass to it the $payment
        return view('billing.payment.edit', compact('payment'));
    }


    /**
     * Update the specified payment in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::find($id);
        $payment->patient_id = $request->patient_id;
        $payment->charge_id = $request->charge_id;
        $payment->full_amount = $request->full_amount;
        $payment->amount_paid = $request->amount_paid;
        $payment->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)
        	->with('message', trans('terms.record-successfully-saved'))
        	->with('active_payment', $payment ->id);
    }


    /**
     * Remove the specified payment from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $url = session('SOURCE_URL');

        return redirect()->to($url)
        	->with('message', trans('terms.record-successfully-deleted'));
    }
}
