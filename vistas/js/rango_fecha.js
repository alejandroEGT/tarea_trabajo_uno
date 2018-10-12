$(document).ready(function($) {
		
		fecha_automatic_en_input_date()
		
	
	});	

	function fecha_automatic_en_input_date() {
		f= new Date();
		d= f.getDate();
		m= ("0" + (f.getMonth())).slice(-2)
		a= f.getFullYear();
		console.log(d+"/"+m+"/"+a);
		var date_desde = document.querySelector('input[id="f_desde"]');
		var date_hasta = document.querySelector('input[id="f_hasta"]');
		date_desde.value = a+'-'+m+'-'+d;
		date_hasta.value = a+'-'+m+'-'+d;
	}

	function get_user() {
			$.ajax({
		     	method: "POST",
		        url: "../codigo/codigo_tabla.php",
		        data:{
		        	'f_desde' : $("#f_desde").val(),
		        	'f_hasta' : $("#f_hasta").val(),
		        	'h_inicio' : $("#h_inicio").val(),
		        	'h_fin' : $("#h_fin").val(),
		        },
		        success : function(data) {
		            var o = JSON.parse(data);//A la variable le asigno el json decodificado

		            $('#example').css('background-color', 'blue');
		            $('#example thead').css('color', 'white');
		            $('#example').dataTable( {
		                data : o,
		                columns: [
		                    {"data" : "id", "visible":false},
		                    {"data" : "nombres"},
		                    {"data" : "apellidos"},
		                    {"data" : "email"},
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
		                bDestroy: true, //permitir destruir datos de la tabla
		                searching: true,//mostrar buscador
		                paging:true, //mostrar paginador
		                info:true, //mostrar informacion
		                ordering: true, //mostrar ordenador de columnas
		                
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

		           
		        }       
		    });
	}