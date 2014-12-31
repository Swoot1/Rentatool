/**
 * Created by Elin on 2014-07-31.
 */
(function () {
   angular.module('Rentatool').factory('AlertBoxService', ['$rootScope', function ($rootScope) {
      var alertBoxService = {};

      $rootScope.alertBoxes = [];

      alertBoxService.addAlertBox = function (type, message) {
         type = alertBoxService.isAllowedType(type) ? type : alertBoxService.getDefaultType();

         return $rootScope.alertBoxes.push(
            {
               type: type,
               message: message,
               close: function () {
                  return alertBoxService.closeAlertBox(this);
               }
            }
         );
      };

      alertBoxService.closeAlertBox = function (alertBox) {
         var index = $rootScope.alertBoxes.indexOf(alertBox);
         $rootScope.alertBoxes.splice(index, 1);
      };

      // Remove alert boxes when the user navigates to a different page.
      $rootScope.$watch(function () {
         return location.hash
      }, function () {
         $rootScope.alertBoxes = [];
      });

      alertBoxService.isAllowedType = function (type) {
         return ['alert', 'success', 'warning', 'info', 'secondary'].indexOf(type) !== -1;
      };

      alertBoxService.getDefaultType = function () {
         return 'success';
      };

      return alertBoxService;
   }]);
})();