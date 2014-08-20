/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-19
 * Time: 19:01
 * To change this template use File | Settings | File Templates.
 */

rentaTool.factory('UserGroupConnection', ['$resource', function ($resource) {
    return $resource('usergroups/:action');
}]);

