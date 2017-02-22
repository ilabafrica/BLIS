var app = angular.module('reports', []);
app.controller('ReportsFilterController', function ReportsFilterController($scope,Report,$http,$sce) {
  $scope.reportTypes = [
    {
      id: 1,
      name: 'Patient Report'
    }, {
      id: 2,
      name: 'Tests Report'
    }, {
      id: 3,
      name: 'Specimen Report'
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
    },
    {
      id:7,
      name:'Lab Sections'
    }
  ];
   $scope.resultsColumns   =[
      {
      id: 1,
      name: 'Test Type'
    }, {
      id: 2,
      name: 'Test:Result'
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
      name: 'Verified By'
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
  $scope.generateReport=function(){
    $scope.thisCanBeusedInsideNgBindHtml ="";
    $scope.dataPost={};

    var results = new Array;
    for(var o in $scope.selected.resultsColumn) {
        results.push($scope.resultsColumns[o-1]);
    }
    var specimen= new Array;
    for(var o in $scope.selected.specimenColumn) {
        specimen.push($scope.specimenColumns[o-1]);
    }

    $scope.dataPost.specimen=specimen;
    $scope.dataPost.results=results;
    $scope.dataPost.to=$scope.selected.to;
    $scope.dataPost.from=$scope.selected.from;
    $scope.dataPost.patient=$scope.selected.patientNo;
    $http.post('adhocreport',$scope.dataPost).then(function(data){
       $scope.thisCanBeusedInsideNgBindHtml = $sce.trustAsHtml(data.data);
       $scope.selected.specimenColumn="";
       $scope.selected.resultsColumn="";
       $scope.report=true;
       
    });
   
  }
  $scope.reporting=function(){
    $scope.report=false;
    $scope.thisCanBeusedInsideNgBindHtml = "";
  }

  $scope.filter=function(){
    alert($scope.filters);
  }


});