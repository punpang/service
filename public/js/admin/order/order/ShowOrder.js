var app = angular.module("myApp", []);
  app.controller("controller", function($scope) {
    $scope.click_modal_confirm_cancel_bill = function(id){
      $scope.cancel_bill_id = id;
    }
  });
