/**
 * Created by Elin on 2014-07-10.
 */
rentaTool.factory('User', ['$resource', function ($resource) {
    return $resource('users/:id', {id: '@id'}, {update: {method: 'PUT'}});
}]);