/**
 * Created by elinnilsson on 12/09/14.
 */

 angular.module('Rentatool')
 .controller('RentalObjectPhotoController', ['$scope', '$http', 'RentalObjectService', function($scope, $http, RentalObjectService){

   $scope.file = {};
   $scope.file.options = {
      url: '/rentatool/files',
      autoUpload: true,
      done:function(e, data){
        RentalObjectService.setPhoto(e, data);
      }
   };

 }]);
