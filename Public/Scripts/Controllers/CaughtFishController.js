/**
 * Created by Elin on 2014-06-12.
 */
rentaTool.controller('CaughtFishController', ['$scope', 'CaughtFish', 'Fish', function ($scope, CaughtFish, Fish) {
    $scope.caughtFishCollection = CaughtFish.query();    
    $scope.fishCollection = Fish.query();
    $scope.caughtFish = new CaughtFish({});

    $scope.createCaughtFish = function () {

        $scope.caughtFish.$save({}, function () {
            alert('Lagt till fångst.');
            $scope.caughtFishCollection.push($scope.caughtFish);
        }, function () {
            alert('Något gick snett.');
        });
    };
}]);