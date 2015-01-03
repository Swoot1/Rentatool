/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-03
 * Time: 15:47
 * To change this template use File | Settings | File Templates.
 */
(function () {
    angular.module('Rentatool').controller('MyRentalObjectsListController', ['$scope', 'NavigationService', 'RentalObject', 'User',  function ($scope, NavigationService, RentalObject, User) {

        // TODO: User rentalobjects resource and add status or create new resource?

        User.get({'id': 'currentUser'}, function(data) {
            $scope.rentalObjectCollection = RentalObject.query({userId: data.id});
            $scope.currentUser = data.id;
        });

    }]);
})();