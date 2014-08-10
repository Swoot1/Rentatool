/**
 * Created by Elin on 2014-07-17.
 */
rentaTool.controller('DatabaseController', ['$scope', 'Database', function ($scope, Database) {

    var database = new Database({});

    $scope.createDatabase = function () {
        database.$save({});
    };

    $scope.createDatabaseWithSeeds = function () {
        database.$save({action: 'createwithseeds'});
    };
}])
;