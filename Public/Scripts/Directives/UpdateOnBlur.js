/**
 * Created by elinnilsson on 06/01/15.
 */
(function () {
   angular.module('Rentatool').directive('updateonblur', [function () {

      return {
         restrict: 'A',
         replace: true,
         template: "<form ng-model-options=\"{updateOn: 'blur', debounce: {default: 500, blur: 0}}\">"
      };
   }])
})();




