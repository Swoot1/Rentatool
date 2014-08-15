/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-15
 * Time: 21:08
 * To change this template use File | Settings | File Templates.
 */

rentaTool.controller('UserGroupListController', ['$scope', '$resource', '$location', 'UserGroup', function ($scope, $resource, $location, UserGroup) {
    $scope.userGroupCollection = UserGroup.query();

    $scope.navigateToCreateUserGroup = function () {
        $location.path('/usergroups/new');
    };

    $scope.updateUserGroup = function (userGroup) {
        $location.path('/usergroups/' + userGroup.id);
    };

    $scope.deleteUserGroup = function (userGroup) {
        var indexOfUserGroup;
        var userGroupResource = new UserGroup(userGroup);
        userGroupResource.$delete({id: userGroup.id},
            function () {
                indexOfUserGroup = $scope.userGroupCollection.indexOf(userGroup);
                $scope.userGroupCollection.splice(indexOfUserGroup, 1);
            });
    };

}]);
