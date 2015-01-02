/**
 * Created by Elin on 2014-07-09
 */
(function () {
   angular.module('Rentatool').controller('NavigationController', ['$scope', '$location', 'MenuItems', 'NavigationService', function ($scope, $location, MenuItems, navigationService) {
      $scope.menuItems = MenuItems.query(function () {
         $scope.menuLoaded = true;
      });

      $scope.navigate = function (menuItem) {
         $scope[menuItem.callback]();
      };

      $scope.$on('loginStateChanged', function () {
         $scope.menuItems = MenuItems.query();
      });

      $scope.navigateToLogIn = navigationService.navigateToLogIn;
      $scope.navigateToUserList = navigationService.navigateToUserList;
      $scope.navigateToRentalObjectList = navigationService.navigateToRentalObjectList;
      $scope.navigateToCreateDatabase = navigationService.navigateToCreateDatabase;
      $scope.navigateToMyBookingList = navigationService.navigateToMyBookingList;
   }]);
}());
