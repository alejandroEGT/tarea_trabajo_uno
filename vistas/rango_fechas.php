<!-- <?php 

	require "../codigo/db.php";

	$sql = "SELECT * FROM users";
	$result = $con->query($sql);
	$users=[];
	$i = 0;

	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()) {
			$users[$i]['nombre'] = $row['nombres'].' '.$row['apellidos'];
			$users[$i]['email'] = $row['email'];
			$users[$i]['creado'] = $row['created_at'];
			$i++;
		}
	}
 ?> -->

<!DOCTYPE html>
<html>
<head>
	<title></title>
 	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>
<body>

<form>
	<table class="blueTable" style="width: 40%">
		<thead>
		<tr>
			<th>Desde</th>
			<th>Hasta</th>
			
		</tr>
		</thead>
		
		<tbody>
			<tr>
				<td>
					<input style="width: 115px" type="date" id="f_desde" >
					<input type="time" id="h_inicio">
				</td>
				<td>
					<input style="width: 115px" type="date" id="f_hasta" >
					<input type="time" id="h_fin">
				</td>
			
			</tr>
		</tbody>

		<tfoot>
			<tr>
			<td colspan="4">
			<center>
				<button onClick="get_user()" type="button" id="btn_busca">Buscar</button>
			</center>
			</td>
			</tr>
		</tfoot>
	</table>
</form>	

	<hr>
	
	<!-- <table>
		<tr>
			<td>Nombre</td>
			<td>Email</td>
			<td>Creado</td>
		</tr>
		<?php foreach ($users as $key): ?>
		<tr>	
			<td><?= $key['nombre'] ?></td>
			<td><?= $key['email'] ?></td>
			<td><?= $key['creado'] ?></td>
		</tr>
		<?php endforeach ?>
	</table> -->


<style type="text/css">
	table.blueTable {
	  border: 1px solid #1C6EA4;
	  background-color: #EEEEEE;
	  width: 100%;
	  text-align: left;
	  border-collapse: collapse;
	}
	table.blueTable td, table.blueTable th {
	  border: 1px solid #AAAAAA;
	  padding: 3px 2px;
	}
	table.blueTable tbody td {
	  font-size: 13px;
	}
	table.blueTable tr:nth-child(even) {
	  background: #D0E4F5;
	}
	table.blueTable thead {
	  background: #1C6EA4;
	  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
	  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
	  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
	  border-bottom: 2px solid #444444;
	}
	table.blueTable thead th {
	  font-size: 15px;
	  font-weight: bold;
	  color: #FFFFFF;
	  border-left: 2px solid #D0E4F5;
	}
	table.blueTable thead th:first-child {
	  border-left: none;
	}

	#btn_busca{
		width: 100px;
	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="js/rango_fecha.js">
</script>

</body>
</html>