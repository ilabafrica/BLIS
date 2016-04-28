<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection as Collection;

class ExternalDump extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'external_dump';

    protected $fillable = array('');

    const TEST_NOT_FOUND = 0;

    /**
    * This function will return a collection of all the measures and the test
    * of a lab request. e.g for Full Heamogram(FH), the function will retrieve the entire
    * tree of the test, from FH (parentLabNo 0) to #LY (the measure of a measure of FH)
    *
    * @param labNo of external lab request
    * @return collection of the entire tree hierarchy
    */
    public function getLabRequestAndMeasures($labNo)
    {
        try 
        {
            $labRequestParent = ExternalDump::where('lab_no', '=', $labNo)->firstOrFail();
        } 
        catch (ModelNotFoundException $e) 
        {
            Log::error("The labNo $labNo does not exist in the staging table, strange!");
            return null;
        }
        $externalLabRequestTree = new Collection();
        $externalLabRequestTree = $this->getLabRequestChildrenRecursive($labNo, $externalLabRequestTree);

        return $externalLabRequestTree;
    }

    private function getLabRequestChildrenRecursive($labNo, $externalLabRequestTree)
    {
        $extLabRequests = ExternalDump::where('parent_lab_no', '=', $labNo)->get();
        if( count($extLabRequests) > 1)
        {
            foreach ($extLabRequests as $extLabRequest)
            {
                $externalLabRequestTree->push($extLabRequest);
                $this->getLabRequestChildrenRecursive($extLabRequest->lab_no, $externalLabRequestTree);
            }
        }

        return $externalLabRequestTree;
    }

}