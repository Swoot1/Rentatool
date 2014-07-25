/**
 * Created by Elin on 2014-07-09.
 */
rentaTool.controller('NavigationController', ['$scope', '$location', function ($scope, $location) {
    $scope.navigateToUserList = function () {
        $location.path('/users');
    };

    $scope.navigateToRentalObjectList = function () {
        $location.path('/rentalobjects');
    };
}]);
