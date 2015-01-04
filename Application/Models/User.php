<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:40
 */

namespace Application\Models;

use Application\PHPFramework\Validation\AddressValidation;
use Application\PHPFramework\Validation\CityValidation;
use Application\PHPFramework\Validation\Collections\ValueValidationCollection;
use Application\PHPFramework\Validation\AlphaNumericValidation;
use Application\PHPFramework\Validation\BooleanValidation;
use Application\PHPFramework\Validation\EmailValidation;
use Application\PHPFramework\Validation\IntegerValidation;
use Application\PHPFramework\Validation\OrganizationNumberValidation;
use Application\PHPFramework\Validation\PasswordValidation;
use Application\PHPFramework\Models\GeneralModel;
use Application\PHPFramework\Validation\PhoneNumberValidation;
use Application\PHPFramework\Validation\ZipCodeValidation;

class User extends GeneralModel{

   protected $id;
   protected $username;
   protected $email;
   protected $password;
   protected $hasAdministrativeAccess = false;
   protected $hasConfirmedEmail = false;
   protected $organizationNumber;
   protected $address = null;
   protected $additionalAddressInformation = null;
   protected $zipCode = null;
   protected $city = null;
   protected $phoneNumber;
   protected $customerRecordsId = null;

   public function __construct(array $data){
      parent::__construct($data);
   }

   protected function setUpValidation(){
      $this->setValidation(new ValueValidationCollection(array(
                                                            new IntegerValidation(
                                                               array(
                                                                  'genericName'  => 'användarid',
                                                                  'propertyName' => 'id'
                                                               )
                                                            ),
                                                            new AlphaNumericValidation(
                                                               array(
                                                                  'genericName'  => 'användarnamn',
                                                                  'propertyName' => 'username',
                                                                  'maxLength'    => 50
                                                               )
                                                            ),
                                                            new EmailValidation(
                                                               array(
                                                                  'genericName'  => 'epost-adress',
                                                                  'propertyName' => 'email'
                                                               )
                                                            ),
                                                            new PasswordValidation(
                                                               array(
                                                                  'genericName'  => 'lösenord',
                                                                  'propertyName' => 'password'
                                                               )
                                                            ),
                                                            new BooleanValidation(
                                                               array(
                                                                  'genericName'  => 'administrativ åtkomst',
                                                                  'propertyName' => 'hasAdministrativeAccess'
                                                               )
                                                            ),
                                                            new OrganizationNumberValidation(
                                                               array(
                                                                  'genericName'  => 'organisationsnummer/personnummer',
                                                                  'propertyName' => 'organizationNumber'
                                                               )
                                                            ),
                                                            new AddressValidation(
                                                               array(
                                                                  'genericName'  => 'adress',
                                                                  'propertyName' => 'address',
                                                                  'allowNull'    => true
                                                               )
                                                            ),
                                                            new AddressValidation(
                                                               array(
                                                                  'genericName'  => 'additionalAddressInformation',
                                                                  'propertyName' => 'address',
                                                                  'allowNull'    => true
                                                               )
                                                            ),
                                                            new ZipCodeValidation(
                                                               array(
                                                                  'genericName'  => 'postnummer',
                                                                  'propertyName' => 'zipCode',
                                                                  'allowNull'    => true
                                                               )
                                                            ),
                                                            new CityValidation(
                                                               array(
                                                                  'genericName'  => 'stad',
                                                                  'propertyName' => 'city',
                                                                  'allowNull'    => true
                                                               )
                                                            ),
                                                            new IntegerValidation(
                                                               array(
                                                                  'genericName'  => 'id:t för integration till kundregister',
                                                                  'propertyName' => 'customerRecordsId',
                                                                  'allowNull'    => true
                                                               )
                                                            ),
                                                            new PhoneNumberValidation(
                                                               array(
                                                                  'genericName'  => 'telefonnummer',
                                                                  'propertyName' => 'phoneNumber',
                                                                  'allowNull'    => true
                                                               )
                                                            )
                                                         )));
   }

   /**
    * @param $password
    * @return bool
    */
   public function isValidPassword($password){
      return password_verify($password, $this->password);
   }

   /**
    * @return mixed
    */
   public function getId(){
      return $this->id;
   }

   /**
    * @return mixed
    */
   public function getEmail(){
      return $this->email;
   }

   /**
    * @return mixed
    */
   public function getUsername(){
      return $this->username;
   }

   public function getPassword(){
      return $this->password;
   }

   public function hasAdministrativeAccess(){
      return $this->hasAdministrativeAccess;
   }
}