<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 14:21
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\PHPFrameworkTests\CollectionTests;

use Application\PHPFramework\Collections\GeneralCollection;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;

class MockModel extends GeneralModel{
   protected $property = '';
   protected $noDbProperty = '';
   protected $propertyNotInData = 'default';

   protected function setUpValidation(){
      $noDBProperties = ['noDbProperty'];
      $validators     = [
         new AlphaNumericValidation(['genericName' => 'Property', 'propertyName' => 'property']),
      ];

      $this->setValidation(new ValueValidationCollection($validators));
      $this->setNoDBProperties($noDBProperties);
   }
}

class MockCollection extends GeneralCollection{
   protected $model = 'Tests\PHPFrameworkTests\CollectionTests\MockModel';
}

class GeneralCollectionTest extends \PHPUnit_Framework_TestCase{

   public function testCreateWithModelArrays(){
      $models = [
         ['property' => 'value'],
         ['property' => 'value']
      ];

      $collection      = new MockCollection($models);
      $collectionArray = $collection->toArray();

      $this->assertEquals(count($models), count($collectionArray));

      foreach ($collectionArray as $modelArray){
         $this->assertArrayHasKey('propertyNotInData', $modelArray, 'A model was created from array data');
      }
   }

   public function testCreateWithModels(){
      $models = [
         new MockModel(['property' => 'value']),
         new MockModel(['property' => 'value'])
      ];

      $collection      = new MockCollection($models);
      $collectionArray = $collection->toArray();

      $this->assertEquals(count($models), count($collectionArray));
   }

   public function testGetDBParameters(){
      $models = [
         ['noDbProperty' => 'stuff'],
         ['noDbProperty' => 'morestuff']
      ];

      $collection      = new MockCollection($models);
      $collectionArray = $collection->getDBParameters();

      $this->assertEquals(count($models), count($collectionArray));

      foreach ($collectionArray as $modelArray){
         $this->assertArrayNotHasKey('noDbProperty', $modelArray);
      }
   }

}