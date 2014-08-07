/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-07
 * Time: 18:48
 * To change this template use File | Settings | File Templates.
 */

rentaTool.factory('RequestSuccessInterceptor', ['$q', 'AlertBoxService', function($q, AlertBoxService) {
    var requestSuccessInterceptor = {
        response: function(response) {

            if(response.data.hasOwnProperty('notifiers') && response.data.notifiers.length > 0) {
                for(var i = 0; i < response.data.notifiers.length; i++) {
                    requestSuccessInterceptor.displayNotifier(response.data.notifiers[i].message, response.data.notifiers[i].type)
                }
            }

            return response;
        },

        displayNotifier: function (message, type) {
            type = AlertBoxService.isAllowedType(type) ? type : AlertBoxService.getDefaultType();
            AlertBoxService.addAlertBox(type, message);
        }
    };

    return requestSuccessInterceptor;
}]);