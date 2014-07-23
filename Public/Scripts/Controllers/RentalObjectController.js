/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', 'RentalObject', function ($scope, RentalObject) {

    $scope.rentalObjectCollection = RentalObject.query();
    $scope.rentalObject = new RentalObject({});
    $scope.rentalObject.available = 1;

    $scope.addRentalObject = function () {
        $scope.rentalObject.$save({}, function (data) {
            alert('Sparat objekt!');
            $scope.rentalObjectCollection.push(data);
        });
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