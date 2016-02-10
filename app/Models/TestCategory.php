<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCategory extends Model
{
	/**
	 * Enabling soft deletes for test categories.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_categories';

	/**
	 * Test types relationship
	 *
	 */
	public function testTypes(){
         return $this->hasMany('App\Models\TestType', 'test_category_id');
      }
    /**
	* Given the test category name we return the test category ID
	*
	* @param $testcategory - the name of the test category
	*/
	public static function getTestCatIdByName($testCategory)
	{
		try 
		{
			$testCatId = TestCategory::where('name', 'like', $testCategory)->firstOrFail();
			return $testCatId->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The test category ` $testCategory ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}