/**
 * Created by Elin on 2014-07-09.
 */
rentaTool.controller('NavigationController', ['$scope', '$location', function ($scope, $location) {
    $scope.navigateToUserList = function () {
        $location.path('/user');
    };

    $scope.navigateToFishList = function () {
        $location.path('/fish');
    };
}]);
