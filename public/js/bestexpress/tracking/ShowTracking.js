var app = angular.module("myApp", []);
  app.controller("controller", function($scope) {

    $scope.loading = 'false';

    $scope.click_loading = function(){
      $scope.loading = 'true';
    }
  });
