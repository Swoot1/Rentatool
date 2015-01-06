/**
 * Created by elinnilsson on 28/09/14.
 */
(function () {
    angular.module('Rentatool')
        .directive('loginbutton', [function () {
            return {
                restrict: 'A',
                replace: 'true',
                template: '<li ng-click="navigateToLogIn()" ng-hide="userIsLoggedIn" class="active"><a href="">Logga in</a></li>'
            };
        }]);
})();
