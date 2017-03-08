angular.module('iBlis')
    .factory('Report', ['$http', function($http) {
        var df = {}; //Data Factory

        df.postReportFilter=function(){
        return  $http.get("/");
    };
    
    return df;
    }]);