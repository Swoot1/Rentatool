/**
 * Created by elinnilsson on 28/09/14.
 */
(function () {
   angular.module('Rentatool')
      .controller('ContentController', ['$scope', '$location', function ($scope, $location) {
         $scope.content = {};

         $scope.$on('$locationChangeStart', function(){
            $scope.content.setContainerClass = $location.path() !== '/authorization/login';
         })
      }]);
})();