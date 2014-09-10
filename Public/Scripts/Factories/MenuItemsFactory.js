/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-09-07
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */

rentaTool.factory('MenuItems', ['$resource', function ($resource) {
    return $resource('menuitems', {});
}]);
