/**
 * Created by Elin on 2014-06-12.
 */
rentaTool.controller('RentalObjectListController', ['$scope', 'RentalObject', function ($scope, RentalObject) {
    $scope.rentalObjectCollection = RentalObject.query();
}]);