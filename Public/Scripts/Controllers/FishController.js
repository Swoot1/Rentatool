/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('FishController', ['$scope', 'Fish', function ($scope, Fish) {

    $scope.fishCollection = Fish.query();

    $scope.addFish = function () {
        $scope.fish = new Fish({});

        $scope.fish.$save({}, function (data) {
            alert('Sparat fisk!');
            $scope.fishCollection.push(data);
        }, function () {
            alert('Något gick snett.');
        });
    };

    $scope.deleteFish = function (fish) {
        var indexOfFish;
        var fishResource = new Fish(fish);
        fishResource.$delete({id: fish.id},
            function () {
                alert('Fisk borttagen.');
                indexOfFish = $scope.fishCollection.indexOf(fish);
                $scope.fishCollection.splice(indexOfFish, 1);
            },
            function () {
                alert('Något gick snett.');
            });
    };
}]);