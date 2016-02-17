<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Configurable;
use App\Models\LabConfig;

use Input;

class LabConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //  Fetch given id
        $cId = Configurable::idByRoute($id);
        $setting = Configurable::find($cId);
        $fields = $setting->fields;
        return view('config.setting.edit', compact('id', 'setting', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $setting = Configurable::find($id);
        foreach (Input::all() as $key => $value)
        {
            if((stripos($key, 'token') !==FALSE) || (stripos($key, 'method') !==FALSE))
            {
                continue;
            }
            else
            {
                $fieldId = $this->strip($key);
                $setting = LabConfig::findOrFail($fieldId);
                $setting->value = $value;
                $setting->user_id = 1;
                $setting->update();
            }
        }
        $url = session('SOURCE_URL');
        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Remove the specified begining of text to get Id alone.
     *
     * @param  int  $id
     * @return Response
     */
    public function strip($field)
    {
        if(($pos = strpos($field, '_')) !== FALSE)
        return substr($field, $pos+1);
    }
}