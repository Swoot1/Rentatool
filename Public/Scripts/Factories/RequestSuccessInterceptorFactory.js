/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 2014-08-07
 * Time: 18:48
 * To change this template use File | Settings | File Templates.
 */

(function () {
   angular.module('Rentatool').factory('RequestSuccessInterceptor', ['$q', 'AlertBoxService', 'PaginationService', function ($q, AlertBoxService, PaginationService) {
      var requestSuccessInterceptor = {
         response: function (response) {
            // .metadata is not set when the html template is fetched.
            var notifiers = response.data.metadata ? response.data.metadata.notificationCollection : [];
            var totalNumberOfRows = response.data.metadata ? response.data.metadata.totalNumberOfRows : null;

            requestSuccessInterceptor.addNotifiers(notifiers);
            PaginationService.setTotalRowsForPagination(totalNumberOfRows);
            response.data = response.data.data || response.data;

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
})();