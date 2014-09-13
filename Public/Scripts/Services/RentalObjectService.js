/**
 * Created by elinnilsson on 13/09/14.
 */
angular.module('Rentatool')
.factory('RentalObjectService', [function(){

      var rentalObjectPhoto = {};
      var setPhoto = function(e, data){
         rentalObjectPhoto = data.result.responseData;
      };

      var getPhoto = function(){
         return rentalObjectPhoto;
      };


      return {
         setPhoto: setPhoto,
         getPhoto: getPhoto
      }
   }]);