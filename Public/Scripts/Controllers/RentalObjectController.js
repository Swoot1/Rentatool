/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', function ($scope, $routeParams, RentalObject, $location) {

    if ($routeParams.id) {
        $scope.rentalObject = RentalObject.get({id: $routeParams.id});
    } else {
        $scope.rentalObject = new RentalObject({});
        $scope.rentalObject.available = true;
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

    $scope.returnToRentalObjectList = function(){
        $location.path('/rentalobjects');
    }
}]);