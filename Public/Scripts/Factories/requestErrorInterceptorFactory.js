/**
 * Created by Elin on 2014-07-16.
 */
rentaTool.factory('RequestErrorInterceptor', ['$q', function ($q) {
    var deferred = $q.defer();
    var requestErrorInterceptor = {
        requestError: function (response) {
            requestErrorInterceptor.writeErrorToConsole(response.data);
            return deferred.promise;
        },
        responseError: function (response) {
            requestErrorInterceptor.writeErrorToConsole(response.data);
            return deferred.promise;
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
}]);