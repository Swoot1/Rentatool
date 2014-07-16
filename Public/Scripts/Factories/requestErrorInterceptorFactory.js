/**
 * Created by Elin on 2014-07-16.
 */
goFish.factory('requestErrorInterceptor', function () {
    var requestErrorInterceptor = {
        requestError: function (response) {
            requestErrorInterceptor.writeError(response.data);
            return response;
        },
        responseError: function (response) {
            requestErrorInterceptor.writeError(response.data);
            return response;
        },
        writeError: function (errorData) {
            if (errorData) {
                for (var propertyName in errorData) {
                    if (errorData.hasOwnProperty(propertyName)) {
                        if (typeof errorData[propertyName] === 'object') {
                            requestErrorInterceptor.writeError(errorData[propertyName]);
                        } else if (errorData[propertyName] instanceof Array) {
                            errorData[propertyName].forEach(function (errorData) {
                                requestErrorInterceptor.writeError(errorData);
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