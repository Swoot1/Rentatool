/**
 * Created by Elin on 2014-04-18.
 */

(function () {
   angular.module('Rentatool').controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', 'NavigationService', 'RentalObjectService', 'User', 'UserService', function ($scope, $routeParams, RentalObject, NavigationService, RentalObjectService, User, UserService) {

      var currentUser;

      var createRentalObject = function () {
         $scope.rentalObject.$save({});
      };

      var updateRentalObject = function () {
         $scope.rentalObject.$update({});
      };


      if ($routeParams.id) {
         $scope.rentalObject = RentalObject.get({id: $routeParams.id});

         if (UserService.isLoggedIn()) {
            currentUser = UserService.getCurrentUser();
         }

         $scope.isUserOwner = function () {
            return currentUser === $scope.rentalObject.userId
         };

         $scope.rentalObjectFormConfiguration = {
            submitFunction: updateRentalObject,
            submitButtonText: 'Uppdatera uthyrningsobjekt'
         };
      } else {
         $scope.rentalObject = new RentalObject({fileCollection: []});
         $scope.rentalObjectFormConfiguration = {
            submitFunction: createRentalObject,
            submitButtonText: 'Spara uthyrningsobjekt'
         };
      }

      $scope.navigateToRentalObjectList = NavigationService.navigateToRentalObjectList;

      $scope.$watch(RentalObjectService.getPhoto, function (photo) {
         if (photo && photo.id) {
            $scope.rentalObject.fileCollection = [photo];
         }
      });
   }]);
})();