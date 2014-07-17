/**
 * Created by Elin on 2014-06-16.
 */
rentaTool.controller('UserController', ['$scope', '$routeParams', '$location', 'User', function ($scope, $routeParams, $location, User) {

    if ($routeParams.id) {
        $scope.user = User.get({id: $routeParams.id});
    }else{
        $scope.user = new User({});
    }



    $scope.createUser = function () {
        $scope.user.$save({}, function () {
            alert('Lagt till användare');
        }, function () {
            alert('Något gick snett.');
        });
    };

    $scope.updateUser = function () {
        $scope.user.$update({}, function () {
            alert('Uppdaterat användare');
        }, function () {
            alert('Något gick snett.');
        });
    };

    $scope.returnToUserList = function () {
        $location.path('/user');
    }
}]);
