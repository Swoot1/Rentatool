/**
 * Created by elinnilsson on 16/01/15.
 */
(function () {
   angular.module('Rentatool').directive('userformtemplate', [function () {
      return {
         restrict: 'A',
         replace: true,
         templateUrl: 'Public/Templates/FormTemplates/userForm.html'
      };
   }]);
})();