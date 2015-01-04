<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-02
 * Time: 18:16
 * To change this template use File | Settings | File Templates.
 */

use Application\Adapters\FortnoxCustomerAdapter;
use Application\Models\Customer;
use Application\PHPFramework\Configurations\FortnoxConfiguration;

class CustomerAdapterTest extends PHPUnit_Framework_TestCase{

   /** @var FortnoxCustomerAdapter */
   private $adapter;

   public function setUp(){
      $customer = new Customer([
                               'id'       => '1',
                               'name'     => 'Anki',
                               'address1' => 'Ankgatan 2',
                               'address2' => '',
                               'zipCode'  => '123412',
                               'city'     => 'Ankeborg'
                               ]);

      $this->adapter = new FortnoxCustomerAdapter($customer);
   }

   public function testGetUrl(){
      $this->assertEquals('https://api.fortnox.se/3/customers/', $this->adapter->getUrl());
   }

   public function testGetHeaders(){
      $expectedHeaders = [
         'Access-Token: ' . FortnoxConfiguration::ACCESS_TOKEN,
         'Client-Secret: ' . FortnoxConfiguration::CLIENT_SECRET,
         'Content-type: ' . FortnoxConfiguration::CONTENT_TYPE,
         'Accept: ' . FortnoxConfiguration::ACCEPT_TYPE
      ];


      $this->assertEquals($expectedHeaders, $this->adapter->getRequestHeaders());
   }

   public function testGetBody(){
      $expectedJSON = '{"Customer":{"Id":"1","Name":"Anki","Address1":"Ankgatan 2","Address2":"","ZipCode":"123412","City":"Ankeborg"}}';
      $this->assertEquals($expectedJSON, $this->adapter->getRequestBody());
   }

}