/**
 * Created by Elin on 2014-06-19.
 */
rentaTool.directive('logoutbutton', [function () {
    return {
        restrict: 'A',
        replace: 'true',
        template: '<li ng-click="attemptLogOut()" class="active"><a href="#">Logga ut mig</a></li>'
    };
}]);