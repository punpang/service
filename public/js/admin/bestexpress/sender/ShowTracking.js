var app = angular.module("myApp", []);
  app.controller("controller", function($scope,$http) {

    $scope.ChooseWaybills = [];
    $scope.ChooseWaybillsAll = [];

    $scope.ChooseWaybill = function(waybill,choose){ //เลือก waybills ที่จะค้นหาจำนวน 20 อัน
      $scope.HasWaybill = $scope.ChooseWaybills.indexOf(waybill);
      if ($scope.HasWaybill != '-1' && choose == 0) {
        $scope.ChooseWaybills.splice($scope.HasWaybill,1);
      }else if ($scope.HasWaybill == '-1' && choose == 1) {
        $scope.ChooseWaybills.push(waybill);
      }

      $scope.URLBEST();
    }

    $scope.URLBEST = function(){
      $scope.WaybillsChoose = '';
      for (var i = 0; i < $scope.ChooseWaybills.length; i++) {
        if (i == 0) {
          $scope.WaybillsChoose = $scope.ChooseWaybills[i];
        }else {
          $scope.WaybillsChoose = $scope.WaybillsChoose + '%2C' + $scope.ChooseWaybills[i];
        }
      }

      if ($scope.WaybillsChoose != '') {
        $scope.GoToTrackingsWeb = 'https://www.best-inc.co.th/track?bills=' + $scope.WaybillsChoose;
      }else {
        $scope.GoToTrackingsWeb = null;
      }
    }

    $scope.RedirectURL = function(url){
      window.location = url;
    }

    $scope.TrackingsAll = function(waybill)
    {
      $scope.ChooseWaybillsAll.push(waybill);
    }

    $scope.ChooseWaybills_All = function(choose){
      if ($scope.ChooseWaybills.length >= 1 && choose == 0) {
        $scope.ChooseWaybills = $scope.ChooseWaybillsAllBefore;
      }else {
        $scope.ChooseWaybillsAllBefore = $scope.ChooseWaybills;
        $scope.ChooseWaybills = $scope.ChooseWaybillsAll;
      }
      $scope.URLBEST();
    }

  });
