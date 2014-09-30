<?php
use Symfony\Component\DomCrawler\Crawler;
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class TestControllerTest extends TestCase 
{

    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

   /**
	  * @group testIndex
	  * @param  
	  * @return 
	  */    
 	  public function testifIndexWorks()
  	{
      echo "\n\nTEST CONTROLLER TEST\n\n";
      $searchbyPending = array('search' => '', 'testStatusId' => '1', 'dateFrom' => '', 'dateTo' => '');//Pending
      $searchbyStarted = array('search' => '', 'testStatusId' => '2', 'dateFrom' => '', 'dateTo' => '');//Started
      $searchbyCompleted = array('search' => '', 'testStatusId' => '3', 'dateFrom' => '', 'dateTo' => '');//Completed
      $searchbyVerified = array('search' => '', 'testStatusId' => '4', 'dateFrom' => '', 'dateTo' => '');//Verified
      $searchbyNonExistentString = array('search' => 'gaslfjkdre', 'testStatusId' => '', 'dateFrom' => '', 'dateTo' => '');//Non existent search string - retun nothing
      $searchBetweenDates = array('search' => '', 'testStatusId' => '', 'dateFrom' => '2014-09-26', 'dateTo' => '2014-09-27');//Between dates - empty
      // $searchBetweenDates = array('search' => '', 'testStatusId' => '', 'dateFrom' => '2014-09-12', 'dateTo' => '2014-09-27');//Between dates - got ecetera
      $searchbyPatientName = array('search' => 'Lance Opiyo', 'testStatusId' => '', 'dateFrom' => '', 'dateTo' => '');//Search by patient Name
      $searchbyPatientNumber = array('search' => '2150', 'testStatusId' => '', 'dateFrom' => '', 'dateTo' => '');//Search by patient Number
      $searchbyTestType = array('search' => 'GXM', 'testStatusId' => '', 'dateFrom' => '', 'dateTo' => '');//Search by test Type
      $searchbySpecimenNumber = array('search' => '4', 'testStatusId' => '', 'dateFrom' => '', 'dateTo' => '');//Search by specimen Number
      $searchbyVisitNumber = array('search' => '7', 'testStatusId' => '', 'dateFrom' => '', 'dateTo' => '');//Search by visit Number


      $this->runIndex($searchbyPending['testStatusId'], $searchbyPending, 'test_status_id');
      $this->runIndex($searchbyStarted['testStatusId'], $searchbyStarted, 'test_status_id');
      $this->runIndex($searchbyCompleted['testStatusId'], $searchbyCompleted, 'test_status_id');
      $this->runIndex($searchbyVerified['testStatusId'], $searchbyVerified, 'test_status_id');
      $this->runIndex(0, $searchbyNonExistentString, 'Non existent string');//Non existent search string
      $this->runIndex(0, $searchBetweenDates, 'Non existent date range');//Between dates
      // $this->runIndex($searchBetweenDates['dateFrom'], $searchBetweenDates, 'time_created');
      // $this->runIndex($searchBetweenDates['dateTo'], $searchBetweenDates, 'time_created');
      $this->runIndex($searchbyPatientName['search'], $searchbyPatientName, 'visit', 'patient', 'name');
      $this->runIndex($searchbyPatientNumber['search'], $searchbyPatientNumber, 'visit', 'patient', 'patient_number');
      $this->runIndex($searchbyTestType['search'], $searchbyTestType, 'testType', 'name');
      $this->runIndex($searchbySpecimenNumber['search'], $searchbySpecimenNumber, 'specimen_id');
      $this->runIndex($searchbyVisitNumber['search'], $searchbyVisitNumber, 'visit_id');
      echo "Search Tested\n";
    }

    // Load the index page
    public function runIndex($searchValue, $formInput, $returnValue, $returnValue2 = null, $returnValue3 = null)
    {
      Input::replace($formInput);
      $controller = new TestController;
      $view = $controller->index();
      $tests = $view->getData()['tests'];
      if (isset($returnValue3)) {
        $field3 = $returnValue3;
        $field2 = $returnValue2;
      }elseif (isset($returnValue2)) {
        $field2 = $returnValue2;
      }
      $field = $returnValue;
      if ($searchValue == '0') {
        $this->assertEquals($searchValue, count($tests));
      }else {
        foreach ($tests as $key => $test) {
            if (isset($field3)) {
              $this->assertEquals($searchValue, $test->{$field}->{$field2}->{$field3});
            }elseif (isset($field2)) {
              $this->assertEquals($searchValue, $test->{$field}->{$field2});
            }else {
              $this->assertEquals($searchValue, $test->{$field});
            }
        }
      }
    }
}