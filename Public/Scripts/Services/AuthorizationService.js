/**
 * Created by elinnilsson on 28/09/14.
 */
angular.module('Rentatool')
   .factory('AuthorizationService', ['UserService', function (UserService) {

      var logIn = function (user) {
         UserService.setCurrentUser(user);
      };

      var logOut = function () {
         UserService.setUserLoggedOut();
      };

      return {
         'logIn': logIn,
         'logOut': logOut
      }

   }]);