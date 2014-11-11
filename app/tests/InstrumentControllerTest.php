<?php
/**
 * Tests the TestController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

class InstrumentControllerTest extends TestCase 
{

    public function setUp(){
      parent::setUp();
      Artisan::call('migrate');
      Artisan::call('db:seed');
    }


    /*-------------------------------------------------------------------------------
    * 14 methods in the InstrumentController class
    *--------------------------------------------------------------------------------
    * - create - Shows create interface
    *   + Check for expected field name: ip
    */
    public function testDisplayCreateForm(){

      $url = URL::route('instrument.create');

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      $ip = $crawler->filter('input#ip')->attr('name');
      $this->assertEquals("ip", $ip);
    }
    /*
    * - saveNewInstrument
    *   + Required Input: name, ip, testtypes
    *   + Check TestController redirects to the correct view ('instrument.index')
    */
    public function testSaveNewInstrumentSuccess(){

      $url = URL::route('instrument.create');

      // Set the current user to admin
      $this->be(User::first());

      $crawler = $this->client->request('GET', $url);

      // Get the form and set the form values
      $form = $crawler->selectButton(trans('messages.save'))->form();
      $form['name'] = 'GeneXpert IV';
      $form['description'] = 'Fully integrated and automated on-demand molecular diagnostic system.';
      $form['ip'] = '10.10.1.10';
      foreach ($form['testtypes'] as $testType) {
        $testType->tick();
        break;
      }

      // Submit the form
      $crawler = $this->client->submit($form);

      $this->assertRedirectedToRoute('instrument.index');
    }

}