/**
 * Created by Elin on 2014-06-12.
 */
rentaTool.controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', function ($scope, $location, RentalObject) {
    $scope.rentalObjectCollection = RentalObject.query();

    $scope.navigateToCreateNewRentalObject = function () {
        $location.path('/rentalobjects/new');
    };

    $scope.editRentalObject = function (rentalObject) {
        $location.path('/rentalobjects/' + rentalObject.id);
    };

    $scope.deleteRentalObject = function (rentalObject) {
        var indexOfRentalObject;
        var rentalObjectResource = new RentalObject(rentalObject);
        rentalObjectResource.$delete({id: rentalObjectResource.id},
            function () {
                alert('Objekt borttagen.');
                indexOfRentalObject = $scope.rentalObjectCollection.indexOf(rentalObject);
                $scope.rentalObjectCollection.splice(indexOfRentalObject, 1);
            });
    };
}]);