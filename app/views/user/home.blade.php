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
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
			    <div class="item active">
			      <img class="img-responsive" src="{{ URL::asset('i/carousel-1.jpg') }}" alt="...">
			      <div class="carousel-caption">
			        <em>Jacquemontia pentanthos</em> on <em>Bougainvillea spectabilis</em> hedges
			      </div>
			    </div>
			    <div class="item">
			      <img class="img-responsive" src="{{ URL::asset('i/carousel-2.jpg') }}" alt="...">
			      <div class="carousel-caption">
			        <em>Leucanthemum maximum</em>
			      </div>
			    </div>
			    <div class="item">
			      <img class="img-responsive" src="{{ URL::asset('i/carousel-3.jpg') }}" alt="...">
			      <div class="carousel-caption">
			        Ipsum solum de collem
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
		</div>
	</div>
@stop