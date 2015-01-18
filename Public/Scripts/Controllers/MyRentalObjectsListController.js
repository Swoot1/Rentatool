/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-03
 * Time: 15:47
 * To change this template use File | Settings | File Templates.
 */
(function () {
    angular.module('Rentatool').controller('MyRentalObjectsListController', ['$scope', 'NavigationService', 'RentalObject', 'User', 'InactivateRentalObject',  function ($scope, NavigationService, RentalObject, User, InactivateRentalObject) {

        User.get({'id': 'currentUser'}, function(data) {
            $scope.rentalObjectCollection = RentalObject.query({userId: data.id});
            $scope.currentUser = data.id;
        });

        $scope.inactivateRentalObject = function (rentalObject) {
            var indexOfRentalObject;
            var inactivateRentalObjectResource = new InactivateRentalObject(rentalObject);

            inactivateRentalObjectResource.$update({id: rentalObject.id},
                function () {
                    indexOfRentalObject = $scope.rentalObjectCollection.indexOf(rentalObject);
                    $scope.rentalObjectCollection.splice(indexOfRentalObject, 1);
                });
        };

        $scope.navigateToRentalObject = NavigationService.navigateToRentalObject;

    }]);
})();