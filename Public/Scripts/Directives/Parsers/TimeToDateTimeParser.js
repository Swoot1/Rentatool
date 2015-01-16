/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('timetodatetimeformatter', [function () {

      return {
         restrict: 'A',
         replace: true,
         require: 'ngModel',
         link: function (scope, element, attributes, ngModelController) {
            var dateObject, date, timeValues, year, month, hours, minutes;
            ngModelController.$parsers.unshift(formatDate);

            function formatDate(viewValue) {

               if (!viewValue) {
                  return viewValue;
               }

               dateObject = new Date();
               timeValues = viewValue.split(':');

               year = dateObject.getFullYear();
               month = ('0' + dateObject.getMonth() + 1).slice(-2); // Add a leading zero. Months are zero based.
               date = ('0' + dateObject.getDate()).slice(-2); // Add a leading zero.
               hours = timeValues[0] || '00';
               minutes = timeValues[1] || '00';

               return year + '-' + month + '-' + date + ' ' + hours + ':' + minutes + ':00';
            }
         }
      };
   }])
})();