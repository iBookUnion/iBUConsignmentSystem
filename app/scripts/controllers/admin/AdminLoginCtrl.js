'use strict';

angular.module('consignmentApp')
  .controller('AdminLoginCtrl', ['$scope', function ($scope) {
    $scope.$on('event:google-plus-signin-success', function (event,authResult) {
      console.log('Sign in successful, now we need to work on sending this to the server!');
    });
  }]);