<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css">
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>

<body>

{{ Datatable::table()
    ->addColumn('ID','Name')       // these are the column headings to be shown
    ->setUrl(route('trial.datatables'))   // this is the route where data will be retrieved
    ->render() }}

</body>
</html>


