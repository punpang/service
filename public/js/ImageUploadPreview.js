var app = angular.module("myApp", []);
app.controller("controller", function($scope, $http) {
    $scope.imgs = [];
    $scope.files = [];
    $scope.imageUpload = function(event) {
        var files = event.target.files;

        for (var i = 0; i < files.length; i++) {
            // console.log(files[i]);
            var file = files[i];
            var reader = new FileReader();
            reader.onload = $scope.imageIsLoaded;
            $scope.imageIsFiles(file);
            reader.readAsDataURL(file);
        }
    }

    $scope.imageIsLoaded = function(e) {
        $scope.$apply(function() {
            // console.log(e.target.result);
            // $scope.img = e.target.result;
            $scope.imgs.push(e.target.result);
            // console.log($scope.imgs);
        });
    }

    $scope.imageIsFiles = function(i) {
        $scope.files.push(i);
        console.log($scope.files);
    }

    $scope.imageIsResetAll = function() {
        $scope.imgs = [];
    }

    $scope.imageIsUpload = function() {
      $http.post('../../../../upload/image/store',$scope.files).then(successCallback, errorCallback);
    }
});
