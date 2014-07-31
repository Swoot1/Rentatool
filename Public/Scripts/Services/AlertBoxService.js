/**
 * Created by Elin on 2014-07-31.
 */
rentaTool.factory('AlertBoxService', ['$rootScope', function ($rootScope) {
    var alertBoxService = {};

    $rootScope.alertBoxes = [];

    alertBoxService.addAlertBox = function (type, message) {

        return $rootScope.alertBoxes.push(
            {
                type: type,
                message: message,
                close: function () {
                    return alertBoxService.closeAlertBox(this);
                }
            }
        );
    };

    alertBoxService.closeAlertBox = function (alertBox) {
        var index = $rootScope.alertBoxes.indexOf(alertBox);
        $rootScope.alertBoxes.splice(index, 1);
    };

    return alertBoxService;
}]);