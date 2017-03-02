@extends("layout")
@section("content")

<div ng-controller="ReportsFilterController"  class="ng-cloak">
	<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.adhoc-report') }}</li>
	</ol>
</div>

    <div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-edit"></span>
			{{ trans('messages.select-report-filters') }}
		</div>
		
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			@if (Session::has('message'))
				<div class="alert alert-info">{{ Session::get('message') }}</div>
			@endif
				<div class='container-fluid'>
                    <form ng-submit="generateReport()">
                    <div class="panel-body">
                     <div class="row">
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-2">
                    
						{{ Form::label('start', trans("messages.from")) }}</div><div class="col-sm-1">
						<input type="text" ng-model="selected.from" class="standard-datepicker" />
			        	
			        </div>
		        </div>
	        </div>
	        <div class="col-sm-3">
				<div class="row">
			        <div class="col-sm-2">
				        {{ Form::label('end', trans("messages.to")) }}
				    </div>
				    <div class="col-sm-1">
		               <input type="text" ng-model="selected.to"  class="standard-datepicker"/>
		            </div>
	            </div>
            </div>
	    </div>
        <div>
                       <strong>  <p>Select the report type</p> </strong>
                        <div class="form-group">
                <select name="reportSelect" id="reportSelect" ng-model="selected.reportTypes" class="form-control" ng-click="reporting()">
                <option ng-repeat="option in reportTypes" value="<%option.id%>" ng-bind="option.name" ><span></span></option>
                </select>
                </div>
   
   
    
     <!--If the patient report has been selected show the parameters required and columns that pertain to the patient report-->
      <div ng-hide="report">
      <div ng-if="selected.reportTypes==1" class="form-group">
            <strong><p>Enter the Patient No </p></strong>
            <label class="" >
            <input type="number" ng-model="selected.patientNo" value="" class="form-control"><span></span>
            </label>

        </div>
        <div ng-if="selected.reportTypes==1 && selected.patientNo">
            <strong><p>Select Columns to be displayed</p></strong>
            <label ng-repeat="section in sections" class="form-group" >
            <input type="checkbox" ng-model="selected.section[section.id]" ng-change="checkedItems(selected.section,section.id)">  <span class="" ng-bind="section.name"> </span>
            </label>
   </div>

        <div ng-if="specimen && selected.reportTypes==1" class="form-group">
            <p>Select Specimen columns to be displayed</p>
            <label ng-repeat="specimenColumn in specimenColumns" class="form-group" >
            <input type="checkbox" ng-model="selected.specimenColumn[specimenColumn.id]">  <span class="" ng-bind="specimenColumn.name"> </span>
            </label>

        </div>
        <div ng-if="results && selected.reportTypes==1" class="form-group">
            <p>Select Results columns to be displayed</p>
            <label ng-repeat="resultsColumn in resultsColumns" class="form-group" >
            <input type="checkbox" ng-model="selected.resultsColumn[resultsColumn.id]">  <span class="" ng-bind="resultsColumn.name"> </span>
            </label>

        </div>
		<!--Test Menus-->
		<div ng-if="selected.reportTypes==2" class="form-group">
		<strong><p>Select a Test</p> </strong>
                        <div class="form-group">
                <select name="testSelect" id="testSelect" ng-model="selected.test" class="form-control">
                <option ng-repeat="option in testtypes.data" value="<%option.id%>" ng-bind="option.name" ><span></span></option>
                </select>
                </div>
		</div>
		<!--Specimen Items-->
		<div ng-if="selected.reportTypes==3" class="form-group">
		<strong><p>Select a Specimen</p> </strong>
                        <div class="form-group">
                <select name="testSelect" id="testSelect" ng-model="selected.specimen" class="form-control">
                <option ng-repeat="option in specimentypes.data" value="<%option.id%>" ng-bind="option.name" ><span></span></option>
                </select>
                </div>
		</div>
		<div ng-if="selected.reportTypes==2 || selected.reportTypes==3 && selected.test || selected.specimen" class="form-group">
		<strong><p>Select a Gender</p> </strong> 
                <div class="form-group">
						<label ng-repeat="gender in genders" class="form-group" >
						<input type="checkbox" ng-model="selected.gender[gender.id]">  <span class="" ng-bind="gender.name"> </span>
						</label>
                
                </div>
		</div>
		<div ng-if="selected.reportTypes==2 || selected.reportTypes==3 && selected.gender" class="form-group">
		<strong><p>Specify Lower Age Limit</p> </strong>
                        <div class="form-group">
                <label>
            <input type="number" ng-model="selected.lowerage" value="" class="form-control"><span></span>
            </label>
                
                </div>
				<strong><p>Specify Upper Age Limit</p> </strong>
                       
                <label>
            <input type="number" ng-model="selected.upperage" value="" class="form-control"><span></span>
            </label>
                
		</div>
		
         </div>
		 <div ng-if="selected.reportTypes==2 || selected.reportTypes==3 && selected.upperage && selected.lowerage" class="form-group">
		<strong><p>Select Columns to Display</p> </strong>
                <div class="form-group">
						<label ng-repeat="testsColumn in testsColumns" class="form-group" >
						<input type="checkbox" ng-model="selected.columns[testsColumn.id]">  <span class="" ng-bind="testsColumn.name"> </span>
						</label>
                </div>
				
		</div>
         </div>
        <div class="" ng-if="selected.reportTypes==2 || selected.reportTypes==3 && selected.columns">
			<div class="form-group actions-row">
				{{ Form::button(
					trans('messages.generate_report'),
					[
						'class' => 'btn btn-primary', 
						'type' => 'submit'
					] 
				) }}
			</div>
		
        </div>
       </form>
       </div>
    <div ng-bind-html="thisCanBeusedInsideNgBindHtml"></div>
</div>

@stop