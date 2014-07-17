/**
 * Created by Elin on 2014-07-17.
 */
rentaTool.factory('Database', ['$resource', function ($resource) {
    return $resource('/database/:action');
}]);