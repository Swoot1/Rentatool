/**
 * Created by Elin on 2014-07-10.
 */
rentaTool.factory('CaughtFish', ['$resource', function ($resource) {
    return $resource('/caughtfish/:id');
}]);