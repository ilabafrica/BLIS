
<?php




class MappingController extends Controller
{
    
    public static function index(Request $request)
    {
      
        // $dataElements = DB::connection('mysql')->table('data_elements')->get();

        // foreach ($dataElements as $dataElement) {

           $result = DB::connection('mysql')->table('emr_test_type_aliases')->insert([
                'client_id' => 5,
                'test_type_id' => DB::connection('mysql')->table('test_types')->where('name',$request->blis_test_type_name)->first()->id,
                'emr_alias' => $request->data_element_id,
            ]);
                
        // }
         return json_encode('Test Request Received');
    }


 




}
