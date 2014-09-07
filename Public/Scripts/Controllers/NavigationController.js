/**
 * Created by Elin on 2014-07-09
 */
rentaTool.controller('NavigationController', ['$scope', '$location', 'MenuItems', function ($scope, $location, MenuItems) {
    $scope.menuItems = MenuItems.query(function() {
        $scope.menuLoaded = true;
    });

    $scope.navigate = function(menuItem) {
      $scope[menuItem.callback]();
    };

    $scope.$on('EVENT_LOGINSTATE_CHANGED', function(){
        $scope.menuItems = MenuItems.query();
    });

   $scope.navigateToLogIn = function () {
      $location.path('/authorization/login');
   };

   $scope.navigateToUserList = function () {
      $location.path('/users');
   };

   $scope.navigateToRentalObjectList = function () {
      $location.path('/rentalobjects');
   };

   $scope.navigateToCreateDatabase = function () {
      $location.path('/databases/new');
   };

   $scope.navigateToUserGroupList = function() {
      $location.path('/usergroups');
   };
}]);
