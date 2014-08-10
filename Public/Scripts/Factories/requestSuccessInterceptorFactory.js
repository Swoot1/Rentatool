/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-07
 * Time: 18:48
 * To change this template use File | Settings | File Templates.
 */

angular.module('Rentatool').factory('RequestSuccessInterceptor', ['$q', 'AlertBoxService', function ($q, AlertBoxService) {
   var requestSuccessInterceptor = {
      response: function (response) {
         var notifiers = response.data.metadata ? response.data.metadata.notificationCollection : [];

         requestSuccessInterceptor.addNotifiers(notifiers);
         response.data = response.data.responseData || response.data;

         return response;
      },

      addNotifiers: function (notifiers) {
         notifiers.forEach(function (notifier) {
            AlertBoxService.addAlertBox(notifier.type, notifier.message);
         });
      }
   };

   return requestSuccessInterceptor;
}]);