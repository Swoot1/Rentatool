/**
 * Created by Elin on 2014-05-26.
 */
rentaTool.directive('ensureUniqueFish', function ($http) {
    return {
        require: 'ngModel',
        link: function (scope, ele, attrs, c) {
            scope.$watch(attrs.ngModel, function (n) {
                var existingFish;

                if (!n) return;

                $http({
                    method: 'GET',
                    url: '/fish'
                }).success(function (data) {
                    existingFish = data.filter(function (fish) {
                        return fish.name === n;
                    });

                    c.$setValidity('unique', existingFish.length === 0);
                })
                    .error(function () {
                        c.$setValidity('unique', false);
                    });
            })
        }
    };
});