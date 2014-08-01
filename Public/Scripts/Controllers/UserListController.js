/**
 * Created by Elin on 2014-06-16.
 */
rentaTool.controller('UserListController', ['$scope', '$resource', '$location', 'User', function ($scope, $resource, $location, User) {
    $scope.userCollection = User.query();

    $scope.navigateToCreateNewUser = function () {
        $location.path('/users/new');
    };

    $scope.updateUser = function (user) {
        $location.path('/users/' + user.id);
    };

    $scope.deleteUser = function (user) {
        var indexOfUser;
        var userResource = new User(user);
        userResource.$delete({id: user.id},
            function () {
                alert('Användare borttagen.');
                indexOfUser = $scope.userCollection.indexOf(user);
                $scope.userCollection.splice(indexOfUser, 1);
            });
    };
}]);