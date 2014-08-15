/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-15
 * Time: 21:10
 * To change this template use File | Settings | File Templates.
 */

rentaTool.factory('UserGroup', ['$resource', function ($resource) {
    return $resource('usergroups/:id', {id: '@id'}, {update: {method: 'PUT'}});
}]);
