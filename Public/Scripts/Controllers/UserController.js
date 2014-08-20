/**
 * Created by Elin on 2014-06-16.
 */
rentaTool.controller('UserController', ['$scope', '$routeParams', '$location', 'User', 'UserGroup', 'UserGroupConnection', function ($scope, $routeParams, $location, User, UserGroup, UserGroupConnection) {

    if ($routeParams.id) {
        $scope.user = User.get({id: $routeParams.id});
    } else {
        $scope.user = new User({});
    }

    $scope.userGroupCollection = UserGroup.query();
    $scope.userGroupConnection = new UserGroupConnection();

    $scope.createUser = function () {
        $scope.user.$save({});
    };

    $scope.updateUser = function () {
        $scope.user.$update({});
    };

    $scope.returnToUserList = function () {
        $location.path('/users');
    };

    $scope.addUserToGroup = function () {
        $scope.userGroupConnection.userId = $scope.user.id;
        $scope.userGroupConnection.$save({action: 'addMember'});
    };

    $scope.removeUserFromGroup = function (group) {
        $scope.userGroupConnection.userId = $scope.user.id;
        $scope.userGroupConnection.groupId = group.id;
        $scope.userGroupConnection.$save({action: 'removeMember'});
    };

}]);
