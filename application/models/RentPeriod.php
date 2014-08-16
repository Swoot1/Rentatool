<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 18:07
 */

namespace Rentatool\Application\Models;


use Rentatool\Application\ENFramework\Collections\ValueValidationCollection;
use Rentatool\Application\ENFramework\Helpers\Validation\DateTimeValidation;
use Rentatool\Application\ENFramework\Helpers\Validation\IntegerValidation;
use Rentatool\Application\ENFramework\Models\GeneralModel;

class RentPeriod extends GeneralModel{
   protected $id;
   protected $rentalObjectId;
   protected $renterId;
   protected $fromDate;
   protected $toDate;

   // TODO add validation so that the from date is not after the to date.
   public function setUpValidation(){
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
            new IntegerValidation(
               array(
                  'genericName'  => 'id: för personen som hyr',
                  'propertyName' => 'renterId'
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
         )
      );
   }

   public function getFromDate(){
      return $this->fromDate;
   }

   public function getToDate(){
      return $this->toDate;
   }

   public function getRentalObjectId(){
      return $this->rentalObjectId;
   }
} 