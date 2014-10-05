<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-10-05
 * Time: 12:12
 * To change this template use File | Settings | File Templates.
 */

use Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;

class MockModel extends GeneralModel{
   protected $property = '';
   protected $secondProperty = '';
   protected $childModel;
   protected $noDbProperty = '';
   protected $_internalProperty = 'internal';

   protected function setUpValidation(){
      $this->_setters = ['secondProperty' => 'setSecondProperty'];
      $noDBProperties = ['noDbProperty'];
      $validators     = [
         new AlphaNumericValidation(['genericName' => 'Property', 'propertyName' => 'property']),
         new AlphaNumericValidation(['genericName' => 'Den andra propertyn', 'propertyName' => 'secondProperty'])
      ];

      $this->setValidation(new ValueValidationCollection($validators));
      $this->setNoDBProperties($noDBProperties);
   }

   public function resetModel() {

   }

   public function getProperty(){
      return $this->property;
   }

   public function getSecondProperty(){
      return $this->secondProperty;
   }

   protected function setSecondProperty($value){
      $this->secondProperty = 'custom' . $value;
   }
}

class GeneralModelTest extends PHPUnit_Framework_TestCase{

   public function testSetDataOnCreation(){
      $model = new MockModel(['property' => 'testValue']);

      $this->assertEquals('testValue', $model->getProperty());
   }

   public function testGetDBParameters(){
      $model        = new MockModel(['property' => 'testValue', 'noDbProperty' => 'anotherTestValue']);
      $dbParameters = $model->getDBParameters();

      $this->assertArrayHasKey('property', $dbParameters);
      $this->assertArrayNotHasKey('noDbProperty', $dbParameters);
      $this->assertArrayNotHasKey('_internalProperty', $dbParameters);
   }

   public function testGetDBParametersWithChildModel(){
      $model        = new MockModel(['property' => 'testValue', 'childModel' => new MockModel(['property' => 'childTestValue'])]);
      $dbParameters = $model->getDBParameters();

      $this->assertEquals('testValue', $dbParameters['property']);
      $this->assertEquals('childTestValue', $dbParameters['childModel']['property']);
   }

   public function testCustomSetter(){
      $model = new MockModel(['secondProperty' => 'value']);

      $this->assertEquals('customvalue', $model->getSecondProperty());
   }

   public function testToArray(){
      $model      = new MockModel();
      $modelArray = $model->toArray();

      $this->assertArrayHasKey('property', $modelArray);
      $this->assertArrayHasKey('secondProperty', $modelArray);
      $this->assertArrayHasKey('noDbProperty', $modelArray);
      $this->assertArrayNotHasKey('_internalProperty', $modelArray);
   }

   public function testToArrayWithChildModel(){
      $model      = new MockModel(['childModel' => new MockModel()]);
      $modelArray = $model->toArray();

      $this->assertInternalType('array', $modelArray['childModel']);
   }

   public function testToArrayWithChildModelWithoutToArray(){
      $model      = new MockModel(['childModel' => new stdClass()]);
      $modelArray = $model->toArray();

      $this->assertInstanceOf('stdClass', $modelArray['childModel']);
   }

   public function testSetDefaultValues() {
      $this->markTestIncomplete('Not sure if _defaultValues are used anywhere');
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Property måste vara alfanumeriskt.
    */
   public function testValidatorWithoutCustomSetter(){
      new MockModel(['property' => '(╯°□°）╯︵ ┻━┻']);
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Den andra propertyn måste vara alfanumeriskt.
    */
   public function testValidatorWithCustomSetter(){
      new MockModel(['secondProperty' => '(╯°□°）╯︵ ┻━┻']);
   }

   /**
    * @expectedException        \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ogiltigt egenskapsnamn.
    */
   public function testSetInvalidProperty(){
      new MockModel(['invalidProperty' => 'should not work']);
   }


}