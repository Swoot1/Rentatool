/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', function ($scope, $routeParams, RentalObject) {

    if ($routeParams.id) {
        $scope.rentalObject = RentalObject.get({id: $routeParams.id});
    } else {
        $scope.rentalObject = new RentalObject({});
        $scope.rentalObject.available = 1;
    }

    $scope.createRentalObject = function () {
        $scope.rentalObject.$save({}, function (data) {
            alert('Sparat objekt!');
            $scope.rentalObjectCollection.push(data);
        });
    };

    $scope.updateRentalObject = function () {
        $scope.rentalObject.$update({}, function () {
            alert('Uppdaterat uthyrningsobjektet');
        });
    };
}]);