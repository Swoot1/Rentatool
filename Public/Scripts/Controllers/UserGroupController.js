/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-15
 * Time: 21:31
 * To change this template use File | Settings | File Templates.
 */

rentaTool.controller('UserGroupController', ['$scope', '$resource', '$location', '$routeParams', 'UserGroup', function ($scope, $resource, $location, $routeParams, UserGroup) {

    if ($routeParams.id) {
        $scope.userGroup = UserGroup.get({id: $routeParams.id});
    } else {
        $scope.userGroup = new UserGroup({});
    }

    $scope.returnToUserGroupList = function () {
        $location.path('/usergroups');
    };

    $scope.createUserGroup = function () {
        $scope.userGroup.$save({});
    };

    $scope.updateUserGroup = function () {
        $scope.userGroup.$update({})
    };

}]);
