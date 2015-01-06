/**
 * Created by Elin on 2014-06-19.
 */
(function () {
    angular.module('Rentatool')
        .directive('logoutbutton', [function () {
            return {
                restrict: 'A',
                replace: 'true',
                template: '<li ng-click="attemptLogOut()" ng-show="userIsLoggedIn" class="active"><a href="">Logga ut</a></li>'
            };
        }]);
})();
