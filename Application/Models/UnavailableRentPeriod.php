<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 04/09/14
 * Time: 17:27
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\DateTimeValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class UnavailableRentPeriod extends GeneralModel{

   protected $id;
   protected $rentalObjectId;
   protected $fromDate;
   protected $toDate;

   protected function setUpValidation(){
      $this->_validation = new ValueValidationCollection(
         array(
            new IntegerValidation(
               array(
                  'genericName'  => 'id:t',
                  'propertyName' => 'id'
               )
            ),
            new IntegerValidation(
               array(
                  'genericName'  => 'uthyrningsobjektets id',
                  'propertyName' => 'rentalObjectId'
               )
            ),
            new DateTimeValidation(
               array(
                  'genericName'  => 'från datum',
                  'propertyName' => 'fromDate'
               )
            ),
            new DateTimeValidation(
               array(
                  'genericName'  => 'till datum',
                  'propertyName' => 'toDate'
               )
            )
         ));
   }
}