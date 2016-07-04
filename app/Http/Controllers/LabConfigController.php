<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\LabConfigRequest;

use App\Models\Configurable;
use App\Models\LabConfig;
use App\Models\Field;
use App\Models\ConField;
use App\Models\Analyser;

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
        $analysers = [];
        $analyser = NULL;
        if($id=='equipment')
        {
            $analysers = Analyser::lists('name', 'id');
        }
        if(!$analyser)
        {
            $analyser = Analyser::first();
            // $id = $analyser->id;
        }
        //  Fetch given id
        if($id=='equipment')
            $cId = Configurable::idByName($analyser->name);
        else
            $cId = Configurable::idByRoute($id);
        $setting = Configurable::find($cId);
        $fields = $setting->fields;
        return view('config.setting.edit', compact('id', 'setting', 'fields', 'analysers', 'analyser'));
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
        if(Input::get('equi'))
        {
            $anId = Input::get('equi');
            $id = Configurable::idByName(Analyser::find($anId)->name);
        }
        $conf = Configurable::find((int)$id);
        foreach (Input::all() as $key => $value)
        {
            if((stripos($key, 'token') !==FALSE) || (stripos($key, 'method') !==FALSE) || (stripos($key, 'equi') !==FALSE))
            {
                continue;
            }
            else if(stripos($key, 'field') !==FALSE)
            {
                if(strlen($value)>0)
                {
                    $fieldId = $this->strip($key);
                    $conId = ConField::where('configurable_id', $conf->id)->where('field_id', (int)$fieldId)->first();
                    $counter = count(LabConfig::where('key', $conId->id)->get());
                    if($counter == 0)
                        $setting = new LabConfig;
                    else                    
                        $setting = LabConfig::where('key', $conId->id)->first();
                    $setting->key = $conId->id;
                    $setting->value = $value;
                    if(Field::find($fieldId)->field_type == Field::FILEBROWSER)
                        $setting->value = $this->imageModifier(Input::file('field_'.$fieldId));
                    $setting->user_id = 1;
                    $counter==0?$setting->save():$setting->update();
                }
            }
        }
        $url = session('SOURCE_URL');
        return redirect()->to($url)->with('message', trans('messages.record-successfully-updated'));
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
    /**
     * Change the image name, move it to images/profile, and return its new name
     *
     * @param $request
     * @param $data
     * @return string
     */
    private function imageModifier($image)
    {
        if(empty($image)){
            $filename = 'default.png';
        }else{
            $ext = $image->getClientOriginalExtension();
            $filename = uniqid() . "." . $ext;
            $image->move('img/', $filename);
        }
        return $filename;
    }

    /**
     * Fetch settings of the given analyzer 
     *
     * @param  int  $id
     * @return Response
     */
    public function fetch()
    {
        $id = Input::get('analyzer_id');
        $analyzer = Analyser::find($id);
        $cId = Configurable::idByName($analyzer->name);
        $setting = Configurable::find($cId);
        $fields = $setting->fields;
        foreach ($fields as $field)
        {
            $field->conf($setting->id)?$field->data=$field->conf($setting->id)->setting->value:$field->data='';
        }
        return json_encode($fields);
    }
    /**
    *
    *   Function to generate config file for instrumentation
    *
    */
    public function configFile()
    {
        $id = Input::get('analyzer_id');
        $analyzer = Analyser::find($id);
        $cId = Configurable::idByName($analyzer->name);
        $setting = Configurable::find($cId);
        $fields = $setting->fields;

        // Part 1
        $file = 'BLISInterfaceClient/part1.txt';
        $current = file_get_contents($file);
        $config_p1 = str_replace("--FS--", $analyzer->feedsource(), $current);

        //Part2
        if ($analyzer->feed_source == Analyser::RS232)
            $file = 'BLISInterfaceClient/rs232.txt';
        else if ($analyzer->feed_source == Analyser::TEXT)
            $file = 'BLISInterfaceClient/flatfile.txt';
        else if ($analyzer->feed_source == Analyser::MSACCESS)
            $file = 'BLISInterfaceClient/msaccess.txt';
        else if ($analyzer->feed_source == Analyser::HTTP)
            $file = 'BLISInterfaceClient/http.txt';
        else if ($analyzer->feed_source == Analyser::TCPIP)
            $file = 'BLISInterfaceClient/tcpip.txt';

        $current = file_get_contents($file);
        $config_p2 ="";
        foreach ($fields as $field)
        {
            $config_p2 = str_replace("--".$field->field_name."--",$field->field_name." = ". $field->conf($setting->id)->setting->value, $current);
            $current = $config_p2;
        }
        echo $config_p2;


        //Part 3
        $file = 'BLISInterfaceClient/part3.txt';
        $current = file_get_contents($file);
        $config_p3 = str_replace("--BLIS_URL--", 'http://'.$_SERVER['HTTP_HOST'], $current);


        //Part 4
        $file = 'BLISInterfaceClient/part4.txt';
        $current = file_get_contents($file);
        $config_p4 = str_replace("--EQUIP_NAME--", $analyzer->name, $current);


        //Concatenated file
        $config_file_content = $config_p1."\n".$config_p2."\n".$config_p3."\n".$config_p4;
        $file2 = 'BLISInterfaceClient/BLISInterfaceClient.ini';
        file_put_contents($file2, $config_file_content);
    }
}