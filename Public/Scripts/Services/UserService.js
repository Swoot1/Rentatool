/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-05
 * Time: 19:57
 * To change this template use File | Settings | File Templates.
 */
(function () {
    angular.module('Rentatool').factory('UserService', ['$cookieStore', '$rootScope', function ($cookies, $rootScope) {

        var UserService = {};

        UserService.isLoggedIn = function() {
            return this.getCurrentUser() !== null;
        };

        UserService.setUserLoggedOut = function(){
            $rootScope.userIsLoggedIn = false;
            this.setCurrentUser(null);
        };

        UserService.setCurrentUser = function(user){
            if(user) {
                $rootScope.userIsLoggedIn = true;
            }

            $cookies.put('currentUser', user);
        };

        UserService.getCurrentUser = function(){
            return $cookies.get('currentUser') || null;
        };

        return UserService;

    }]);

})();