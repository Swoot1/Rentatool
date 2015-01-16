/**
 * Created by elinnilsson on 16/01/15.
 */
(function () {
   angular.module('Rentatool').directive('rentalobjectformtemplate', [function () {
      return {
         restrict: 'A',
         replace: true,
         templateUrl: 'Public/Templates/FormTemplates/rentalObjectForm.html'
      };
   }]);
})();