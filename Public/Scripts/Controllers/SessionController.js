/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2015-01-21
 * Time: 22:02
 * To change this template use File | Settings | File Templates.
 */
(function() {
    angular.module('Rentatool').controller('SessionController', ['UserService', '$rootScope', function (UserService, $rootScope) {
        $rootScope.userIsLoggedIn = UserService.isLoggedIn();
    }]);
})();