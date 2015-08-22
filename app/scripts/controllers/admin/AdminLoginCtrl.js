'use strict';

angular.module('consignmentApp')
  .controller('AdminLoginCtrl', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {

      $scope.logIn = logIn;

      if (isAdmin()) {
        console.log('redirect');
        redirectUser();
      }

      function logIn() {
        Parse.User.logIn($scope.loginForm.username, $scope.loginForm.password)
          .then(redirectUser)
          .fail(promptRetry);
      }

      function redirectUser() {
        $location.path('/admin');

        // Need to use jquery since signout element is outside of ngView
        var signoutLink = $('#signoutLink');
        if (Parse.User.current()) {
          signoutLink.removeClass('hide');
        }
      }

      function isAdmin() {
        // TODO: When we have more user roles, check if user has admin role here
        return Parse.User.current();
      }

      function promptRetry(error) {
        if (error.code === 101) { // Replace Parse message with a more user friendly one.
          $scope.errorMessage = 'Login error - ' + 'incorrect username or password.';
        } else {
          $scope.errorMessage = 'Login error - ' + error.message;
        }
      }
    }]);