@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.report',2) }}</li>
	  <li class="active">{{ trans('messages.moh-706') }}</li>
	</ol>
</div>
<div class="panel panel-primary">
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
			<div class='container-fluid'>
				<strong>Facility Name: </strong><u>Bungoma District Hospital</u><strong> Reporting Period Begining: </strong><u>Bungoma District Hospital</u>
				<strong> Ending: </strong><u>Bungoma District Hospital</u><strong> Affilliation: </strong><u>GOK</u>
				<br />
				<p>N/B: INDICATE N/S Where there is no service</p>
				<div class='row'>
					<div class="col-sm-12">
						<!-- <strong>URINE ANALYSIS</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Urine Chemistry</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
								</tr>
								<tr>
									<td>Glucose</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
						</table> -->
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Urine Microscopy</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Blood Chemistry</th>
								</tr>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4"> Number positive</th>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
							</tbody>
						</table>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Renal function tests</th>
								</tr>
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
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Liver Function Tests</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Lipid Profile</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">CSF Chemistry</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Body Fluids</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="7">Thyroid Function Tests</th>
								</tr>
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
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
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
					<div class="col-sm-12">
						<strong>PARASITOLOGY</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="5">Blood Smears</th>
								</tr>
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
								<tr>
									<td colspan="5"><strong>Genital Smears</strong></td>
								</tr>
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
									<td colspan="5"><strong>Spleen/bone marrow</strong></td>
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
								<tr>
									<td colspan="5"><strong>Stool</strong></td>
								</tr>
								<tr>
									<td colspan="5">Total</td>
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
								<tr>
									<td colspan="5"><strong>Lavages</strong></td>
								</tr>
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
					<div class="col-sm-12">
					<strong>BACTERIOLOGY</strong>
						<div class="row">
							<div class="col-sm-4">
								<table class="table table-condensed report-table-border" style="padding-right:5px;">
									<tbody style="text-align:right;">
										<tr>
											<td>Total examinations done</td>
											<td>0</td>
										</tr>
										<tr>
											<td>Urine</td>
											<td>0</td>
										</tr>
											<td>Pus swabs</td>
											<td></td>
										</tr>
										</tr>
											<td>High Vaginal swab</td>
											<td></td>
										</tr>
										</tr>
											<td>Throat swab</td>
											<td></td>
										</tr>
										</tr>
											<td>Stool</td>
											<td></td>
										</tr>
										</tr>
											<td>Rectal swab</td>
											<td></td>
										</tr>
										</tr>
											<td>Blood</td>
											<td></td>
										</tr>
										</tr>
											<td>CSF</td>
											<td></td>
										</tr>
										</tr>
											<td>Water</td>
											<td></td>
										</tr>
										</tr>
											<td>Food</td>
											<td></td>
										</tr>
										</tr>
											<td>Other (specify)....</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-8">
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td colspan="3">Drugs</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="3">Sensitivity (Total done)</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="3">Resistance per drug</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="3">KOH Preparations</td>
											<td>Fungi</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td colspan="2">Others (specify)</td>
										</tr>
										<tr>
											<td>Others</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>...</td>
											<td></td>
										</tr>
										<tr>
											<td>Total</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>...</td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<p>SPUTUM</p>
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td></td>
											<td>Total</td>
											<td>Positive</td>
										</tr>
										<tr>
											<td>TB new suspects</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Followup</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>TB smears</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>MDR</td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<table class="table table-condensed report-table-border">
							<tbody>
								<tr>
									<td></td>
									<td>Urine</td>
									<td>Pus</td>
									<td>HVS</td>
									<td>Throat</td>
									<td>Stool</td>
									<td>Blood</td>
									<td>CSF</td>
									<td>Water</td>
									<td>Food</td>
									<td>Other fluids</td>
								</tr>
								<tr>
									<td>Naisseria</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Klebsiella</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Staphyloccoci</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Streptoccoci</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Proteus</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Shigella</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Salmonella</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>V. cholera</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>E. coli</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>C. neoformans</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cardinella vaginalis</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Haemophilus</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Bordotella pertusis</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Pseudomonas</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Coliforms</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Faecal coliforms</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Enterococcus faecalis</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Total viable counts-22C</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Total viable counts-37C</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Clostridium</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
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
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="11">Specify species of each isolate</td>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-12">
								<strong>HEMATOLOGY REPORT</strong>
								<table class="table table-condensed report-table-border">
									<thead>
										<tr>
											<th colspan="2">Type of examination</th>
											<th>No. of Tests</th>
											<th>Controls</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="2">Full blood count</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Manual WBC counts</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Peripheral blood films</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Erythrocyte Sedimentation rate</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Sickling test</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">HB electrophoresis</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">G6PD screening</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Bleeding time</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Clotting time</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Prothrombin test</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Partial prothrombin time</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Bone Marrow Aspirates</td>
											<td></td>
											<td style="background-color: #CCCCCC;"></td>
										</tr>
										<tr>
											<td colspan="2">Reticulocyte counts</td>
											<td></td>
											<td style="background-color: #CCCCCC;"></td>
										</tr>
										<tr>
											<td colspan="2">Others</td>
											<td></td>
											<td style="background-color: #CCCCCC;"></td>
										</tr>
										<tr>
											<td rowspan="2">Haemoglobin</td>
											<td>No. Tests</td>
											<td>&lt;5</td>
											<td>5&lt;Hb&lt;10</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">CD4/CD8</td>
											<td>No. Tests</td>
											<td>&lt;200</td>
											<td>200-350</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">CD4%</td>
											<td>No. Tests</td>
											<td>&lt;25%</td>
											<td>&gt;25%</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">Peripheral Blood Films</td>
											<td>Parasites</td>
											<td colspan="2">No. smears with inclusions</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td colspan="2"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12">
								<strong>BLOOD GROUPING AND CROSSMATCH REPORT</strong>
								<div class="row">
									<div class="col-sm-6">
										<table class="table table-condensed report-table-border">
											<tbody>
												<tr>
													<td>Total groupings done</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood units grouped</td>
													<td></td>
												</tr>
												<tr>
													<td>Total transfusion reactions</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood cross matches</td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-sm-6">
										<strong>Blood safety</strong>
										<table class="table table-condensed report-table-border">
											<tbody>
												<tr>
													<td>Measure</td>
													<td>Number</td>
												</tr>
												<tr>
													<td>A. Blood units collected from regional blood transfusion centres</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood units collected from other centres and screened at health facility</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood units screened at health facility that are HIV positive</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood units screened at health facility that are Hepatitis positive</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood units positive for other infections</td>
													<td></td>
												</tr>
												<tr>
													<td>Blood units transfered</td>
													<td></td>
												</tr>
												<tr>
													<td rowspan="2">General remarks .............................</td>
													<td rowspan="2"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<strong>HISTOLOGY AND CYTOLOGY REPORT</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th rowspan="2">Total</th>
									<th rowspan="2">Normal</th>
									<th rowspan="2">Infective</th>
									<th colspan="2">Non-infective</th>
									<th colspan="3">Positive findings</th>
								</tr>
								<tr>
									<th>Benign</th>
									<th>Malignant</th>
									<th>&lt;5 yrs</th>
									<th>5-14 yrs</th>
									<th>&gt;14 yrs</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="9">SMEARS</td>
								</tr>
								<tr>
									<td>Pap Smear</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Tissue Impressions</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="9">TISSUE ASPIRATES (FNA)</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="9">FLUID CYTOLOGY</td>
								</tr>
								<tr>
									<td>Ascitic fluid</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>CSF</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Pleural fluid</td>
									<td></td>
									<td></td>
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
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="9">TISSUE HISTOLOGY</td>
								</tr>
								<tr>
									<td>Cervix</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Prostrate</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Breast</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Ovarian cyst</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Fibroids</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Lymph nodes</td>
									<td></td>
									<td></td>
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
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<strong>SEROLOGY REPORT</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2">Serological test</th>
									<th colspan="2">Total</th>
									<th colspan="2">&lt;5 yrs</th>
									<th colspan="2">5-14 yrs</th>
									<th colspan="2">&gt;14 yrs</th>
								</tr>
								<tr>
									<th>Tested</th>
									<th>No. +ve</th>
									<th>Tested</th>
									<th>No. +ve</th>
									<th>Tested</th>
									<th>No. +ve</th>
									<th>Tested</th>
									<th>No. +ve</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Rapid Plasma Region</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>TPHA</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>ASO Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>HIV Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Widal Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Brucella Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Rheumatoid Factor Tests</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cryptococcal Antigen</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Helicobacter pylori test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hepatitis A test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hepatitis B test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hepatitis C test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Viral Load</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Formal Gel Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Other Tests</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<br />
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th>Dried Blood Spots</th>
									<th>Tested</th>
									<th># +ve</th>
									<th>Discrepant</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Early Infant Diagnosis of HIV</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Quality Assurance</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Discordant couples</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p><strong>Specimen referral to higher levels</strong></p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th>Specimen</th>
									<th>No</th>
									<th>Sent to</th>
									<th>No. of Reports/results received</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop