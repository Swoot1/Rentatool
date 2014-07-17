/**
 * Created by Elin on 2014-07-09.
 */
rentaTool.controller('CaughtFishListController', ['$scope', '$resource', function($scope, $resource){
    var CaughtFishResource = $resource('caughtfish/:id');
    $scope.caughtFishCollection = CaughtFishResource.query();
}]);