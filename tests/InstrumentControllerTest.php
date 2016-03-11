<?php
/**
 * Instrumentation Tests
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class InstrumentControllerTest extends TestCase 
{

    use WithoutMiddleware;
    public function setUp(){
      parent::setUp();
      Artisan::call('migrate');
      Artisan::call('db:seed');
    }


    /*-------------------------------------------------------------------------------
    *  InstrumentController and Instrument classes
    *--------------------------------------------------------------------------------
    * 1. list all equipment
    *    - Click equipment side menu
    *    - Check InstrumentController redirects to the correct view ('instrument.index')
    */

    /*
    * 2. create - Shows create interface
    *    - Click 'New Equipment' button on 'instrument.index' page
    *    - Check for an expected field name: ip
    */
    public function testDisplayCreateForm(){

      echo "\n\nINSTRUMENT CONTROLLER TEST\n\n";

      $url = URL::route('instrument.create');

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      $name = $crawler->filter('input#name')->attr('name');
      $this->assertEquals("name", $name);
    }

    /*
    * 3. store - Save a newly defined instruments locational details
    *    - Click 'New Equipment' button on 'instrument.index' page
    *    - Fill out the form. Input: instrument*, ip*, hostname
    *    - Click 'Save' button
    *    - Outcomes:
    *      + Validation Failure: redirect to 'instrument.create'
    *      + Success saving: redirects to 'instrument.index' with success message
    *      + Failure saving: redirects to 'instrument.index' with failure message. DB failure/Corrupt driver
    */

    /*
    * 4. show - Display instrument details
    *    - Click 'View' button on 'instrument.index' page
    *    - Check for redirection to 'instrument.show' then an expected string: {trans...compatible-test-types}
    */

    /*
    * 5. edit - Shows edit instrument interface
    *    - Click 'Edit' button on 'instrument.index' page
    *    - Check for an expected field name: ip
    */
 
    /*
    * 6. update - Save edited details of an instrument
    *    - Click 'Edit' button on 'instrument.index' page
    *    - Fill out the form. Input: name*, description, ip*, hostname
    *    - Click 'Save' button
    *    - Outcomes:
    *      + Validation Failure: redirect to 'instrument.edit'
    *      + Success saving: redirects to 'instrument.index' with success message
    *      + Failure saving: redirects to 'instrument.index' with failure message. DB failure
    */

    /*
    * 7. delete - Deletes an instrument
    *    - Click 'Delete' button on 'instrument.index' page
    *    - Click 'Delete' button in the confirmation dialog
    *    - Check for redirection to 'instrument.index' with success message
    */
 
    /*
    * 8. getTestResult - Fetch data from a configured instrument
    *    - Click 'Edit/Enter Results' button on 'instrument.index' page for a well configured test {WBC}
    *    - Empty fields.
    *    - Click 'Fetch' button
    *    - Check that fields have been repopulated
    */

    /*
    * 9. importDriver - Import Equipment Driver
    *    - Click 'New Driver' button on 'instrument.index' page
    *    - On the resultant dialog box, click 'Browse', pick a file, then click 'Save'.
    *    - Outcomes:
    *      + Validation Failure: redirects to 'instrument.index' with validation failure message
    *      + Success saving: redirects to 'instrument.index' with success message
    *      + Failure saving: redirects to 'instrument.index' with failure message. No FS Write permissions, Invalid file
    */
 
}