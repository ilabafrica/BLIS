@extends("layout")
@section("content")
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-home	"></span>
			Home Page
		</div>
		<div class="panel-body">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="10000">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			    <div class="item active">
			      <img class="img-responsive" src="{{ URL::asset('i/two.JPG') }}" alt="...">
			      <div class="carousel-caption">
			        Specimen ready for testing
			      </div>
			    </div>
			    <div class="item">
			      <img class="img-responsive" src="{{ URL::asset('i/three.JPG') }}" alt="...">
			      <div class="carousel-caption">
			        Full Haemogram machine - CELLTAC F
			      </div>
			    </div>
			    <div class="item">
			      <img class="img-responsive" src="{{ URL::asset('i/five.JPG') }}" alt="...">
			      <div class="carousel-caption">
			        Specimen in preparation for testing
			      </div>
			    </div>
			    <div class="item">
			      <img class="img-responsive" src="{{ URL::asset('i/six.JPG') }}" alt="...">
			      <div class="carousel-caption">
			        Humalyzer 200 machine for laboratory tests
			      </div>
			    </div>
			  </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left"></span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right"></span>
			  </a>
			</div>
			@include("loader")
		</div>
	</div>
@stop