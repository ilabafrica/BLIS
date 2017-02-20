'use strict';

// Declare app level module which depends on views, and components
angular.module('iBlis', [
  'ngRoute'
]).
config(['$locationProvider', '$routeProvider','$interpolateProvider', function($locationProvider, $routeProvider,$interpolateProvider) {
  $locationProvider.hashPrefix('!');
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
  $routeProvider.otherwise({redirectTo: '/view1'});
}]).controller('ReportsFilterController', function ReportsFilterController($scope,Report) {
  $scope.reportTypes = [
    {
      id: 1,
      name: 'Patient Report'
    }, {
      id: 2,
      name: 'Surveillance Report'
    }, {
      id: 3,
      name: 'Infections Report'
    }
  ];

  $scope.sections   =[
      {
      id: 1,
      name: 'Specimen'
    }, {
      id: 2,
      name: 'Results'
    }
  ];
   $scope.specimenColumns   =[
      {
      id: 1,
      name: 'Type'
    }, {
      id: 2,
      name: 'Tests'
    },{
      id: 3,
      name: 'Date Ordered'
    },{
      id: 4,
      name: 'Status'
    },{
      id: 5,
      name: 'Collected By/Rejected by'
    },{
      id: 6,
      name: 'Date Checked'
    }
  ];
   $scope.resultsColumns   =[
      {
      id: 1,
      name: 'Test Type'
    }, {
      id: 2,
      name: 'Test Results'
    },{
      id: 3,
      name: 'Remarks'
    },{
      id: 4,
      name: 'Performed By'
    },{
      id: 5,
      name: 'Results Entry Date'
    },{
      id: 6,
      name: 'Date Tested'
    },{
      id: 7,
      name: 'Verified by'
    }
  ];
  
  //Check if specimen is Checked
  $scope.checkedItems=function(item,id){
      if(id===1){
          $scope.specimen=item[1];
      }else if(id===2){
          $scope.results=item[2];
      }
  }
});