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
   //Get Tests
  $http.get('testtype?raw=true').then(function(data){
       data.data.push({'id':-1,'name':"All Tests"});
       $scope.testtypes=data;
    });

  //Get specimens types 
  $http.get('specimentype?raw=true').then(function(data){
       $scope.specimentypes=data;
    });
  //Test Columns
  $scope.testsColumns   =[
      {
      id: 1,
      name: 'Test Types'
    }, {
      id: 2,
      name: 'Gender'
    },{
      id: 3,
      name: 'Age Ranges'
    },{
      id: 4,
      name: 'Total Tests'
    }
  ];
  //Gender
  $scope.genders   =[
      {
      id: 1,
      name: 'Male'
    }, {
      id: 2,
      name: 'Female'
    }
  ];
  //Test Statuses
  const NOT_RECEIVED = 1;
	const PENDING = 2;
	const STARTED = 3;
	const COMPLETED = 4;
	const VERIFIED = 5;

	/**
	 * Other constants
	 */
	const POSITIVE = 'Positive';
  $scope.teststatuses=[
  {
    id:1, 
    name:'NOT_RECEIVED'},
    {
      id:2,
      name:'PENDING'
    },
    {
      id:3,
      name:'STARTED'
    },
    {
      id:4,
      name:'COMPLETED'
    },
    {
      id:5,
      name:'VERIFIED'
    }
  ]
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
    var testColumns= new Array;
    for(var o in $scope.selected.columns) {
        testColumns.push($scope.testsColumns[o-1]);
    }
     var gender=new Array;
     for(var o in $scope.selected.gender) {
        gender.push($scope.genders[o-1]);
    }
    var status=new Array;
     for(var o in $scope.selected.statuscolumns) {
        status.push($scope.teststatuses[o-1]);
    }
   
    if($scope.selected.reportTypes==1){
      $scope.dataPost.report=$scope.selected.reportTypes;
      $scope.dataPost.specimen=specimen;
      $scope.dataPost.results=results;
      $scope.dataPost.to=$scope.selected.to;
      $scope.dataPost.from=$scope.selected.from;
      $scope.dataPost.patient=$scope.selected.patientNo;
    }else if($scope.selected.reportTypes==2){
     
      $scope.dataPost.report=$scope.selected.reportTypes;
      $scope.dataPost.testColumns=testColumns;
      $scope.dataPost.testType=$scope.selected.test;
      $scope.dataPost.statusColumns=status;
      $scope.dataPost.to=$scope.selected.to;
      $scope.dataPost.from=$scope.selected.from;
      $scope.dataPost.gender=gender;
      $scope.dataPost.lowerage=$scope.selected.lowerage;
      $scope.dataPost.upperage=$scope.selected.upperage;
      console.log($scope.dataPost);
      //return;
    }else if($scope.selected.reportTypes==3){
      $scope.dataPost.report=$scope.selected.reportTypes;
      $scope.dataPost.testColumns=testColumns;
      $scope.dataPost.testType=$scope.selected.specimen;
      $scope.dataPost.to=$scope.selected.to;
      $scope.dataPost.from=$scope.selected.from;
      $scope.dataPost.gender=gender;
      $scope.dataPost.lowerage=$scope.selected.lowerage;
      $scope.dataPost.upperage=$scope.selected.upperage;
      
    }else{
      $scope.dataPost.report=$scope.selected.reportTypes;
      return;
    }
    if($scope.dataPost){
    $http.post('adhocreport',$scope.dataPost).then(function(data){
       $scope.thisCanBeusedInsideNgBindHtml = $sce.trustAsHtml(data.data);
       $scope.selected.specimenColumn="";
       $scope.selected.resultsColumn="";
       $scope.report=true;
       $scope.selected.columns="";
       $scope.selected.gender="";
       $scope.selected.reportTypes="";
       $scope.selected.statuscolumns="";
       
    });
    }
  }
  $scope.reporting=function(){
    $scope.report=false;
    $scope.thisCanBeusedInsideNgBindHtml = "";
  }

  $scope.filter=function(){
    alert($scope.filters);
  }
});