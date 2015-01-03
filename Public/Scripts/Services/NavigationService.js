/**
 * Created by elinnilsson on 28/09/14.
 */
angular.module('Rentatool')
    .factory('NavigationService', ['$location', function ($location) {

        var navigationService = {};

        navigationService.navigateToLogIn = function () {
            $location.path('/authorization/login');
        };

        navigationService.navigateToUserList = function () {
            $location.path('/users');
        };

        navigationService.navigateToRentalObjectList = function () {
            $location.path('/rentalobjects');
        };

        navigationService.navigateToCreateDatabase = function () {
            $location.path('/databases/new');
        };

        navigationService.navigateToResetPassword = function () {
            $location.path('/resetpasswords/new');
        };

        navigationService.navigateToMyBookingList = function () {
            $location.path('/mybookings');
        };

        navigationService.navigateToMyBooking = function (id) {
            $location.path('/mybookings/' + id);
        };

        navigationService.navigateToMyRentalObjectsList = function () {
            $location.path('/myrentalobjects');
        };


        return navigationService;
    }]);