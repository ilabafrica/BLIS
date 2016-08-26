<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TestCategory extends Eloquent
{
	/**
	 * Enabling soft deletes for test categories.
	 *
	 */
	use SoftDeletingTrait;
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
         return $this->hasMany('TestType', 'test_category_id');
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
	/**
	 * critical values relationship
	 *
	 */
	public function criticals()
	{
        return $this->hasMany('CritVal', 'test_category_id');
    }
}