<?php 

	switch ($_REQUEST['method']) {
		case 'llenar_select_user':
			select_user();
		break;

		case 'get_datos':
			$id_user = $_POST['id_user'];
			$id_rama = $_POST['id_rama'];
			$f_desde = $_POST['f_desde'];
			$f_hasta = $_POST['f_hasta'];
			$h_inicio = $_POST['h_inicio'];
			$h_fin = $_POST['h_fin'];

			get_datos($id_user, $id_rama, $f_desde, $f_hasta, $h_inicio, $h_fin);
		break;

		case 'select_rama_by_user':
			$id_user = $_GET['id_user'];
			select_rama_by_user($id_user);
			break;
		
		default:
			# code...
			break;
	}





	function select_user()
	{
		require "db.php";
		$json = [];
		$i=0;
		$datos = $con->query("SELECT * FROM users");

		foreach ($datos as $key) {
			$json[$i]['id'] = $key['id'];
			$json[$i]['nombre'] = $key['nombres'] . ' ' . $key['apellidos'];
			$i++;
		}
		echo json_encode($json);
		
	}






	function select_rama_by_user($id_user)
	{	
		require "db.php";
		$i = 0;
		$json_rama = [];

		$rama = $con->query("SELECT * FROM `rama` where id_user = " . $id_user);

		if ($rama->num_rows > 0) {
			foreach ($rama as $key) {
				$json_rama[$i]['id'] = $key['id'];
				$json_rama[$i]['descripcion'] = $key['descripcion'];
				$i++;
			}
			echo json_encode($json_rama);
		}else{
			echo json_encode(0);
		}
		
	}








	function get_datos($id_user, $id_rama, $f_desde, $f_hasta, $h_inicio, $h_fin )
	{
			require "db.php";
			$array_datos = [];
			$i=0;
			$desde = $f_desde.' '.$h_inicio;
			$hasta = $f_hasta.' '.$h_fin;


			$datos = $con->query("SELECT an.id as an_id, u.nombres, r.descripcion as rama_descripcion, r.sueldo as rama_sueldo, r.created_at as rama_fecha_creacion, an.monto as anotacion_monto, an.created_at as anotacion_fecha_creado, cu.cuenta as cuenta, t.tipo FROM `rama` as r inner join `users` as u on u.id = r.id_user inner join `anotacion` as an on an.id_rama = r.id inner join `tipo` as t on t.id = an.id_tipo inner join `cuenta` as cu on cu.id = an.id_cuenta where u.id = $id_user AND r.id = $id_rama AND r.id = 1 AND an.created_at >= '$desde' AND an.created_at <= '$hasta'");


			foreach ($datos as $key) {
				$array_datos[$i]['id'] =$key['an_id'];	
				$array_datos[$i]['nombres'] =$key['nombres'];	
				$array_datos[$i]['rama_descripcion'] =$key['rama_descripcion'];
				$array_datos[$i]['rama_sueldo'] =$key['rama_sueldo'];	
				$array_datos[$i]['rama_fecha_creacion'] =$key['rama_fecha_creacion'];	
				$array_datos[$i]['anotacion_monto'] =$key['anotacion_monto'];
				$array_datos[$i]['anotacion_fecha_creado'] =$key['anotacion_fecha_creado'];
				$array_datos[$i]['cuenta'] =$key['cuenta'];
				$array_datos[$i]['tipo'] =$key['tipo'];	
				$i++;	
			}
			echo json_encode($array_datos);
	}



 ?>