<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>
<body>
	<div class="container">

		<form>
			<table class="blueTable" style="width: 40%">
				<thead>
				<tr>
					<th>Usuario</th>
					<th>Rama</th>
					<th>Desde</th>
					<th>Hasta</th>
					
				</tr>
				</thead>
				
				<tbody>
					<tr>
						<td>
							<select onchange="select_rama_by_user()" id="id_user" name="id_user" >
								<option value="0">Seleccione...</option>
							</select>
						</td>
						<td>
							<select  id="id_rama" name="id_rama" >
								<option value="0">Seleccione...</option>
							</select>
						</td>
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
					<td><button type="button" onclick="btn_consultar()" >Consultar</button></td>
				</tfoot>
			</table>
			<br>
			
		</form>


		<hr>
		
		<div id="examplePadre" style="display: none;">
			<table id="example" class="table table-responsive" style="width:100%">
		       	 <thead>
		       	 	<tr>
		       	 		<td><strong>id</strong></td>
		       	 		<td><strong>Usuario</strong></td>
		       	 		<td><strong>rama</strong></td>
		       	 		<td><strong>rama sueldo</strong></td>
		       	 		<td><strong>rama creacion</strong></td>
		       	 		<td><strong>anotacion monto</strong></td>
		       	 		<td><strong>anotacion creación</strong></td>
		       	 		<td><strong>cuenta</strong></td>
		       	 		<td><strong>tipo</strong></td>
		       	 		<td><strong>Option</strong></td>
		       	 		<td><strong>Option</strong></td>
		       	 	</tr>
		       	 </thead>
		       	 <tbody></tbody> 
		    </table>
		</div>
	</div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="js/rango_fecha.js"></script>
<script>
	$(document).ready(function($) {
		
		llenar_select_user();

	});

	function llenar_select_user() {

		$.getJSON('../codigo/cargar_datos.php',{
			method: 'llenar_select_user'
		}
		, function(json, textStatus) {
				$.each(json,function(key, data) {
			       $("#id_user").append('<option value='+data.id+'>'+data.nombre+'</option>');
			    }); 
		});

	}

	function select_rama_by_user() {
		//alert($("#id_user").val());
		$.getJSON('../codigo/cargar_datos.php', 
			{	method:'select_rama_by_user',
				id_user: $("#id_user").val()
			}, function(json, textStatus) {
				$("#id_rama").empty();
				$("#id_rama").append('<option value="0">Seleccione...</option>');
				if (json != 0) {
					$.each(json,function(key, data) {
			       		$("#id_rama").append('<option value='+data.id+'>'+data.descripcion+'</option>');
			    	})
				}
				
		});
	}

	function btn_consultar() {

		desde = new Date($("#f_desde").val());
		hasta = new Date($("#f_hasta").val());

		if(desde < hasta){

			$.post('../codigo/cargar_datos.php', 
				{
					method: 'get_datos',
					id_user: $("#id_user").val(),
					id_rama: $("#id_rama").val(),
					f_desde: $("#f_desde").val(),
					f_hasta: $("#f_hasta").val(),
					h_inicio: $("#h_inicio").val(),
					h_fin: $("#h_fin").val()
				}
			, function(data) {
					
					var o = JSON.parse(data);//A la variable le asigno el json decodificado
					console.log(o);
					if(o.length > 0){
						$('#examplePadre').css('display','block');
					}else{
						$('#examplePadre').css('display','none');
					}

			             $('#example').dataTable( {
			                data : o,
			                columns: [
			                    {"data" : "id", "visible":false},
			                    {"data" : "nombres"},
			                    {"data" : "rama_descripcion"},
			                    {"data" : "rama_sueldo"},
			                    {"data" : "rama_fecha_creacion"},
			                    {"data" : "anotacion_monto"},
			                    {"data" : "anotacion_fecha_creado"},
			                    {"data" : "cuenta"},
			                    {"data" : "tipo"},
			                    {
					                sTitle: "Accion",
					                mDataProp: "id",
					                sWidth: '7%',
					                orderable: false,
					                render: function(data) {
					                    acciones = `<a href="showUser.php?id=` + data + `" class="btn btn-success btn-xs accionesTabla">
					                                    Ver
					                                </a>`;
					                    return acciones
					                }
					            },
					            {
					                sTitle: "Accion",
					                mDataProp: "id",
					                sWidth: '7%',
					                orderable: false,
					                render: function(data) {
					                    acciones = `<button type='button' onClick="click_delete(` + data + `)" class="btn btn-danger btn-xs accionesTabla">
					                                    Eliminar
					                                </button>`;
					                    return acciones
					                }
					            }

			                ],
			                processing: true,
			                bDestroy: true, //permitir destruir datos de la tabla
			                searching: false,//mostrar buscador
			                paging:true, //mostrar paginador
			                info:false, //mostrar informacion
			                ordering: false, //mostrar ordenador de columnas
			                
			                language:{
							    "sProcessing":     "Procesando...",
							    "sLengthMenu":     "Mostrar _MENU_ registros",
							    "sZeroRecords":    "No se encontraron resultados",
							    "sEmptyTable":     "Ningún dato disponible en esta tabla",
							    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
							    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
							    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
							    "sInfoPostFix":    "",
							    "sSearch":         "Buscar:",
							    "sUrl":            "",
							    "sInfoThousands":  ",",
							    "sLoadingRecords": "Cargando...",
							    "oPaginate": {
							        "sFirst":    "Primero",
							        "sLast":     "Último",
							        "sNext":     "Siguiente",
							        "sPrevious": "Anterior"
							    },
							    "oAria": {
							        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
							    }
							}
				 });

			});
		}else{
			alert("La ultima fecha es menor o igual que la primera fecha")
		}
	}

</script>
<style type="text/css">
	#example thead{
		color:white;
		background-color: #AED6F1;
	}
	

	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		  background: none;
		  color: black!important;
		  border-radius: 4px;
		  border: 1px solid #828282;
	}
		 
	.dataTables_wrapper .dataTables_paginate .paginate_button:active {
		  background: none;
		  color: black!important;
	}
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
</html>