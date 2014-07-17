/**
 * Created by Elin on 2014-06-19.
 */
rentaTool.directive('logoutbutton', [function () {
    return {
        restrict: 'A',
        replace: 'true',
        template: '<button ng-click="attemptLogOut()">Logga ut mig nu</button>'
//        link: function($scope, $element, $attrs, sessionController){
//
//        }

    };
}]);