@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.moh-706') }}</li>
	</ol>
</div>
<div class="panel panel-primary" style="font-size:9px;">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.moh-706') }}
	</div>
	<div class="panel-body">
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif	
		<table width="100%">
			<thead>
	            <tr>
	            	<td colspan="3" style="text-align:center;">
	                    <strong><p>MINISTRY OF HEALTH<br>
	                    LABORATORY TESTS DATA SUMMARY REPORT FORM<br></p></strong>
	            	</td>
	            </tr>
            </thead>
		</table>
		<div class="table-responsive">
			<strong>Facility Name: </strong><u>Bungoma District Hospital</u><strong> Reporting Period Begining: </strong><u>Bungoma District Hospital</u>
			<strong> Ending: </strong><u>Bungoma District Hospital</u><strong> Affilliation: </strong><u>GOK</u>
			<br />
			<p>N/B: INDICATE N/S Where there is no service</p>
			<div class='container-fluid'>
				<div class='row'>
					<div class="col-sm-2">
						<strong>URINE ANALYSIS</strong>
						<p>Urine Chemistry</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4"> Number positive</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Glucose</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Ketones</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Proteins</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Blood</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Bilirubin</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Urobilinogen Pyruvic acid</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>HGC</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Urine Microscopy</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4"> Number positive</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Pus cells (&gt;5/hpf)</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>S. haematobium</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>T. vaginalis</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Yeast cells</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Red blood cells</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Bacteria</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Spermatozoa</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Blood Chemistry</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4">Total</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>Low</th>
									<th>Normal</th>
									<th>High</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Fasting blood sugar</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Random blood sugar</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>OGTT</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="7">Renal function tests</td>
								</tr>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Creatinine</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Urea</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Sodium</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Potassium</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Chloride</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Liver Function Tests</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4">Total</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>Low</th>
									<th>Normal</th>
									<th>High</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Direct bilirubin</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Total bilirubin</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>ASAT (SGOT)</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>ASAT (SGPT)</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Serum Protein</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Albumin</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Alkaline Phosphate</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Gamma GT</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Lipid Profile</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4">Total</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>Low</th>
									<th>Normal</th>
									<th>High</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Amylase</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Total cholestrol</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Trigycerides</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>HDL</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>LDE</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>PSA</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>CSF Chemistry</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4">Total</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>Low</th>
									<th>Normal</th>
									<th>High</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Protein</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Glucose</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Body Fluids</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4">Total</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>Low</th>
									<th>Normal</th>
									<th>High</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Proteins</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Glucose</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Acid phosphatase</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Bence jones protein</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Thyroid Function Tests</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4">Total</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>Low</th>
									<th>Normal</th>
									<th>High</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>T3</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>T4</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>TSH</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-2">
						<strong>PARASITOLOGY</strong>
						<p>Blood Smears</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2">Malaria</th>
									<th colspan="4">Positive</th>
								</tr>
								<tr>
									<th>Total Done</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Falciparum</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Ovale</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Malariae</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Vivax</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Borrelia</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Microfilariae</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Trypanosomes</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Genital Smears</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="4">Positive</th>
								</tr>
								<tr>
									<th>Total Done</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>T. vaginalis</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>S. haematobium</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Yeast cells</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Spleen/bone marrow</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>L. donovani</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Stool</p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="4">Positive</th>
								</tr>
								<tr>
									<th>Total Done</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Taenia spp.</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>H. nana</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>H. Diminuta</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hookworm</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Roundworms</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>S. mansoni</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Trichuris trichiura</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Strongyloides stercoralis</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Isospora belli</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>E hystolytica</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td  rowspan="2">Giardia lamblia</td>
								</tr>
								<tr>
									<td>cysts</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>trophozoites</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cryptosporidium</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cyclospora</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5"><strong>Skin snips</strong></td>
								</tr>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Onchocerca volvulus</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Leishmania</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>Lavages</p>
						<table class="table table-condensed report-table-border">
							<tbody>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-4">
						
					</div>
					<div class="col-sm-4"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop