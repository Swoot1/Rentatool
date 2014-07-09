/**
 * Created by Elin on 2014-07-09.
 */
goFish.controller('NavigationController', ['$scope', '$location', function ($scope, $location) {
    $scope.navigateToUserList = function () {
        $location.path('/user');
    };

    $scope.navigateToCaughtFishList = function () {
        $location.path('/caughtfish');
    };

    $scope.navigateToFishList = function () {
        $location.path('/fish');
    };
}]);
