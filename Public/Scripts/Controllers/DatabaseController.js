/**
 * Created by Elin on 2014-07-17.
 */
rentaTool.controller('DatabaseController', ['$scope', 'Database', function ($scope, Database) {

    var database = new Database({});

    $scope.createDatabase = function () {
        database.$save({}, function (data) {
            alert('Skapat databas!');
        });
    };

    $scope.createDatabaseWithSeeds = function () {
        database.$save({action: 'createwithseeds'}, function () {
            alert('Skapat databas!');
        });
    };
}])
;