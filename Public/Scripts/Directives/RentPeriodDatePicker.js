/**
 * Created by elinnilsson on 30/08/14.
 */
(function () {
   angular.module('Rentatool').directive('rentperioddatepicker', ['UnavailableRentPeriodService', function (UnavailableRentPeriodService) {
      return {
         require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
             scope.$watch('rentalObject', function(rentalObject) {

                 var rentalObjectId = rentalObject.id;
                 var unavailableRentPeriods;

                 if (rentalObjectId) {
                     UnavailableRentPeriodService.getUnavailableRentPeriods(rentalObjectId, function (result) {
                             unavailableRentPeriods = result;
                             element.datepicker();

                             element.datepicker('option', 'dateFormat', 'yy-mm-dd');
                             element.datepicker('option', 'minDate', 0);
                             element.datepicker('option', 'onSelect', function (dateText) {
                                 ngModelCtrl.$setViewValue(dateText);
                                 scope.$apply();
                             });


                             element.datepicker('option', 'beforeShowDay', function (date) {
                                 var unavailableRentDate = unavailableRentPeriods.some(function (unavailableRentPeriod) {
                                     return date >= new Date(unavailableRentPeriod.fromDate) && date <= new Date(unavailableRentPeriod.toDate);
                                 });

                                 return unavailableRentDate ? [false, '', 'Verkar som att någon annan hann före dig.'] : [true];
                             });
                         }
                     );
                 }

             }, true);
         }
      };
   }]);
})();