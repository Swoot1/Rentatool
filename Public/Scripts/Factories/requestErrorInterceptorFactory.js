/**
 * Created by Elin on 2014-07-16.
 */
rentaTool.factory('requestErrorInterceptor', function () {
    var requestErrorInterceptor = {
        requestError: function (response) {
            requestErrorInterceptor.writeErrorToConsole(response.data);
            return {};
        },
        responseError: function (response) {
            requestErrorInterceptor.writeErrorToConsole(response.data);
            return {};
        },
        writeErrorToConsole: function (errorData) {
            if (errorData) {
                for (var propertyName in errorData) {
                    if (errorData.hasOwnProperty(propertyName)) {
                        if (typeof errorData[propertyName] === 'object') {
                            requestErrorInterceptor.writeErrorToConsole(errorData[propertyName]);
                        } else if (errorData[propertyName] instanceof Array) {
                            errorData[propertyName].forEach(function (errorData) {
                                requestErrorInterceptor.writeErrorToConsole(errorData);
                            });
                        } else {
                            console.log(propertyName + ': ' + errorData[propertyName] + '\n');
                        }
                    }
                }
            }
        }
    };

    return requestErrorInterceptor;
});