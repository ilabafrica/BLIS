<?php
/**
 * Tests the TestController functions that store, edit and delete measures 
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
      $searchbyPending = array('search' => '', 'test_status' => '1', 'date_from' => '', 'date_to' => '');//Pending
      $searchbyStarted = array('search' => '', 'test_status' => '2', 'date_from' => '', 'date_to' => '');//Started
      $searchbyCompleted = array('search' => '', 'test_status' => '3', 'date_from' => '', 'date_to' => '');//Completed
      $searchbyVerified = array('search' => '', 'test_status' => '4', 'date_from' => '', 'date_to' => '');//Verified
      //Non existent search string - return nothing
      $searchbyNonExistentString = array('search' => 'gaslfjkdre', 'test_status' => '', 'date_from' => '', 'date_to' => '');
      //Between dates - empty
      $searchBetweenDates = array('search' => '', 'test_status' => '', 'date_from' => '2014-09-26', 'date_to' => '2014-09-27');
      //Search by patient Name
      $searchbyPatientName = array('search' => 'Lance Opiyo', 'test_status' => '', 'date_from' => '', 'date_to' => '');
      //Search by patient Number
      $searchbyPatientNumber = array('search' => '2150', 'test_status' => '', 'date_from' => '', 'date_to' => '');
      //Search by test Type
      $searchbyTestType = array('search' => 'GXM', 'test_status' => '', 'date_from' => '', 'date_to' => '');
      //Search by specimen Number
      $searchbySpecimenNumber = array('search' => '4', 'test_status' => '', 'date_from' => '', 'date_to' => '');
      //Search by visit Number
      $searchbyVisitNumber = array('search' => '7', 'test_status' => '', 'date_from' => '', 'date_to' => '');


      $this->runIndex($searchbyPending['test_status'], $searchbyPending, 'test_status_id');
      $this->runIndex($searchbyStarted['test_status'], $searchbyStarted, 'test_status_id');
      $this->runIndex($searchbyCompleted['test_status'], $searchbyCompleted, 'test_status_id');
      $this->runIndex($searchbyVerified['test_status'], $searchbyVerified, 'test_status_id');
      $this->runIndex(0, $searchbyNonExistentString, 'Non existent string');//Non existent search string
      $this->runIndex(0, $searchBetweenDates, 'Non existent date range');//Between dates

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
      $tests = $view->getData()['testSet'];
      if (isset($returnValue3)) {
        $field3 = $returnValue3;
        $field2 = $returnValue2;
      }elseif (isset($returnValue2)) {
        $field2 = $returnValue2;
      }
      $field = $returnValue;
      if (is_numeric($searchValue) && ($field == 'specimen_id'  | $field == 'visit_id')) {
        if ($searchValue == '0') {
          $this->assertEquals($searchValue, count($tests));
        } else {
          $this->assertGreaterThanOrEqual(1, count($tests));
        }
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


    /*-------------------------------------------------------------------------------
    * 14 methods in the TestController class: Invoke URLs or methods?
    *--------------------------------------------------------------------------------
    * - create - Shows create interface
    *   + Check(or not) for patient search box?
    *   + Check for expected field names: visit_type, physician, testtypes. One will do.
    */
    public function testDisplayCreateForm(){
      $patient = Patient::first();
      $url = URL::route('test.create', array($patient->id));

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      $visitType = $crawler->filter('select')->attr('name');
      $this->assertEquals("visit_type", $visitType);
    }
    /*
    * - saveNewTest (1 for each type)
    *   + Get random patient
    *   + Get a test type(1 of every testtype available)
    *   + Required Input: physician, testtypes, patient_id, visit_type
    *   + Check TestController redirects to the correct view ('test.index')
    */
    public function testSaveNewTestSuccess(){
      $patient = Patient::first();
      $url = URL::route('test.create', array($patient->id));

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      // Get the form and set the form values
      $form = $crawler->selectButton(trans('messages.save-test'))->form();
      $form['physician'] = 'Dr. Jack Aroe';
      foreach ($form['testtypes'] as $testType) {
        $testType->tick();
      }

      // Submit the form
      $crawler = $this->client->submit($form);

      $this->assertRedirectedToRoute('test.index');
    }
    /*
    * - saveNewTest (1 for each type) - Fails coz form values not set. Tests VALIDATION.
    *   + Get random patient
    *   + Get a test type(1 of every testtype available)
    *   + Check TestController redirects to the correct view ('test.create')
    */
    public function testSaveNewTestFailure(){
      $patient = Patient::first();
      $url = URL::route('test.create', array($patient->id));

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      // Get the form and set the form values
      $form = $crawler->selectButton(trans('messages.save-test'))->form();

      // Submit the form
      $crawler = $this->client->submit($form);

      $this->assertRedirectedToRoute('test.create', array($patient->id));
    }
    /*
    * - index
    *   + Check that returned view has test-create css class defined
    */
    public function testListTests(){
      $url = URL::route('test.index');

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      $this->assertCount(1, $crawler->filter('div.panel.test-create'));
    }
    /*
    * - reject - Attempt to launch rejection form for elligible specimen
    *   i.e. tests that are not NOT_RECEIVED or VERIFIED and whose Specimen is ACCEPTED
    *   + Required input: specimen_id
    *   + Check that returned view contains: rejectionReason, reason_explained_to
    */
    public function testRejectView(){
      $testIDs = Test::where('test_status_id','!=', Test::NOT_RECEIVED)
                ->where('test_status_id','!=', Test::VERIFIED)->lists('id');
      if(count($testIDs) == 0){
        $this->assertTrue(false);
      }

      // Set the current user to admin
      $this->be(User::first());

      foreach ($testIDs as $id) {
        $url = URL::route('test.reject', array(Test::find($id)->specimen_id));
        $crawler = $this->client->request('GET', $url);

        $this->assertCount(1, $crawler->filter('#reject_explained_to'));

        $this->flushSession();
      }
    }
    /*
    * - rejectAction - Check that each test that is not NOT_RECEIVED or VERIFIED,
    *   and whose Specimen is ACCEPTED, can have its Specimen REJECTED
    *   + Required input: specimen_id, rejectionReason, reason_explained_to
    *   + Check TestController redirects to the correct view ('test.index')
    */
    public function testRejectActionSuccess(){
      $testIDs = Test::where('test_status_id','!=', Test::NOT_RECEIVED)
                ->where('test_status_id','!=', Test::VERIFIED)->lists('id');
      if(count($testIDs) == 0){
        $this->assertTrue(false);
      }

      // Set the current user to admin
      $this->be(User::first());

      foreach ($testIDs as $id) {
        $specimenID = Test::find($id)->specimen_id;
        $url = URL::route('test.reject', array($specimenID));
        $crawler = $this->client->request('GET', $url);

        // Get the form and set the form values
        $form = $crawler->selectButton(trans('messages.reject'))->form();
        $form['rejectionReason']->select('15');
        $form['reject_explained_to'] = 'Tim Commerford';

        // Submit the form
        $crawler = $this->client->submit($form);

        $this->assertRedirectedToRoute('test.index');

        $this->flushSession();
      }
    }
    /*
    * - rejectAction - Check that each test that is not NOT_RECEIVED or VERIFIED,
    *   and whose Specimen is ACCEPTED, can have its Specimen REJECTED
    *   + Required input: specimen_id, rejectionReason, reason_explained_to
    *   + Check TestController redirects to the correct view ('test.index')
    *   Tests that VALIDATION is working okay.
    */
    public function testRejectActionFailure(){
      $testIDs = Test::where('test_status_id','!=', Test::NOT_RECEIVED)
                ->where('test_status_id','!=', Test::VERIFIED)->lists('id');
      if(count($testIDs) == 0){
        $this->assertTrue(false);
      }

      // Set the current user to admin
      $this->be(User::first());

      foreach ($testIDs as $id) {

        $specimenID = Test::find($id)->specimen_id;
        $url = URL::route('test.reject', array($specimenID));

        $crawler = $this->client->request('GET', $url);
        // Get the form and set the form values
        $form = $crawler->selectButton(trans('messages.reject'))->form();

        // Submit the form
        $crawler = $this->client->submit($form);
        $this->assertRedirectedToRoute('test.reject', array($specimenID));

        $this->flushSession();
      }
    }
    /*
    * - accept: For all tests whose specimen_status is NOT_COLLECTED, attempt to ACCEPT
    *   + Required input: id (specimen_id)
    *   + Check that the new status of the specimen is ACCEPTED
    */
    public function testAcceptSpecimen(){
      //TODO: Incorporate a JS supporting client like casperjs or selenium
    }
    /*
    * - changeSpecimenType
    *   + Required input: id (specimen_id)
    *   + Check that the returned view has a <select> called specimen_type:
    */
    public function testChangeSpecimenType(){
      //TODO: Incorporate a JS supporting client like casperjs or selenium
    }
    /*
    * - updateSpecimenType
    *   + Required input: id (specimen_id), new specimen_type_id
    *   + Check that the new specimen_type_id is as expected
    */
    public function testUpdateSpecimenType(){
      //TODO: Incorporate a JS supporting client like casperjs or selenium
    }
    /*
    * - start
    *   + Required input: testid
    *   + Check that the new status of the test is STARTED
    */
    public function testStart(){
      //TODO: Incorporate a JS supporting client like casperjs or selenium
    }
    /*
    * - enterResults
    *   + Required input: testid
    *   + Check check view for presence of textarea#interpretation
    */
    public function testEnterResultsView(){
      $tests = Test::where('test_status_id','=', Test::STARTED)
                ->orWhere('test_status_id','=', Test::COMPLETED)->lists('id');

      foreach ($tests as $id) {
        $test = Test::find($id);
        if($test->specimen->specimen_status_id == Specimen::ACCEPTED){
          $url = URL::route('test.enterResults', array($test->id));
          break;
        }
      }

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      $this->assertCount(1, $crawler->filter('textarea#interpretation'));
    }
    /*
    * - saveResults (1 for each test type)
    *   + Varying inputs: interpretation, test_id, m_[measure_id]
    *   + For each test check that at least 1 result is present in test_results
    */
    public function testSaveResults(){
      //TODO: 
    }
    /*
    * - edit
    *   + Required input: testid
    *   + Check check view for presence of textarea#interpretation
    */
    public function testEditTestView(){
      $tests = Test::where('test_status_id','=', Test::COMPLETED)->lists('id');

      // Set the current user to admin
      $this->be(User::first());

      foreach ($tests as $id) {
        $test = Test::find($id);
        if($test->specimen->specimen_status_id == Specimen::ACCEPTED){
          $url = URL::route('test.edit', array($test->id));

          $crawler = $this->client->request('GET', $url);

          $this->assertCount(1, $crawler->filter('textarea#interpretation'));

          $this->flushSession();
        }
      }
    }
    /*
    * - verify
    *   + Required input: testid
    *   + Check that the new status of the test is VERIFIED
    */
    public function testVerifyTest(){
      $tests = Test::where('test_status_id','=', Test::COMPLETED)->lists('id');

      // Set the current user to admin
      $this->be(User::first());

      foreach ($tests as $id) {
        $test = Test::find($id);
        if($test->specimen->specimen_status_id == Specimen::ACCEPTED){
          $url = URL::route('test.verify', array($test->id));

          $crawler = $this->client->request('GET', $url);

          $this->assertTrue(Test::find($id)->test_status_id == Test::VERIFIED);

          $this->flushSession();
        }
      }
    }
    /*
    * - viewDetails
    *   + Required input: testid
    *   + Check that there are 4 panels in total
    */
    public function testViewDetailsView(){

      $url = URL::route('test.viewDetails', array(Test::first()->id));

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      $this->assertCount(4, $crawler->filter('div.panel'));
    }
    /*
    *--------------------------------------------------------------------------------
    */
    /*-------------------------------------------------------------------------------
    * 2 Key methods in the Test (model) class: getWaitTime() and getTurnaroundTime().
    * The rest are relationship indicators.
    *--------------------------------------------------------------------------------
    */
    /*
    * getWaitTime() test
    * 1. Get all tests whose specimen is not NOT_COLLECTED
    * 2. Check that the wait time is positive
    */
    public function testWaitTime(){
      $specIDs = Specimen::where('specimen_status_id','!=', Specimen::NOT_COLLECTED)->lists('id');

      if(count($specIDs) == 0){
        $this->assertTrue(false);
      }

      foreach ($specIDs as $id) {
        $test = Specimen::find($id)->test()->first();
        $this->assertTrue($test->getWaitTime() >= 0);
      }
    }
    /*
    * getTurnaroundTime()
    * 1. Get all tests whose status is either COMPLETED or VERIFIED
    * 2. Check that the turn around time is positive
    */
    public function testGetTurnAroundTime(){
      $testIDs = Test::where('test_status_id','=', Test::COMPLETED)
                ->orWhere('test_status_id','=', Test::VERIFIED)->lists('id');
      if(count($testIDs) == 0){
        $this->assertTrue(false);
      }

      foreach ($testIDs as $id) {
        $test = Test::find($id);
        $this->assertTrue($test->getTurnaroundTime() >= 0);
      }
    }


}