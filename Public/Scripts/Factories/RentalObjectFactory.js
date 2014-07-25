/**
 * Created by Elin on 2014-07-10.
 */
rentaTool.factory('RentalObject', ['$resource', function ($resource) {
    return $resource('rentalobjects/:id', {id: '@id'}, {update: {method: 'PUT'}});
}]);

