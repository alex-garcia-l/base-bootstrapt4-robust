$(document).on("ready", function() {

  $("body").tooltip({
      selector: '[data-toggle="tooltip"]'
  });
  
  /*
   *  Formulario Alta
   */
  
  $("#modal-alta").on("show.bs.modal", function() {
    // Reseteamos formulario y reseteamos valores
    formAlta.validate().resetForm();
    formAlta.find(".form-group").removeClass("has-error");
    formAlta.find("#fieldset-form").attr("disabled", false);
    formAlta[0].reset();
    $("#btnNuevo").html('Guardar');
  });
  
  $("#modal-alta").on("shown.bs.modal", function() {
    // Le ponemos el foco al primer elemento del formulario de nuestro interes
    formAlta.find("#txtNombre").focus();
  });
  
  // Asignamos el evento submit al formulario
  formAlta.on("submit", function(evt) {
    evt.preventDefault();
  }).validate({
        // Quitamos valores del inicio o final que sean espacios
        normalizer: function( value ) {
          return $.trim( value );
        },
        // Establecemos las reglas de nuestro formulario
        rules: {
            txtNombre: {
              required: true,
              texto_con_espacios: true,
              remote: {
                url: "config.php",
                type: "post",
                data: {
                  action: "existe-roles"
                }
              }
            },
            txtDescripcion: {
              texto_direccion: true,
            },
        },
        // Establecemos los mensajes de error para las reglas de nuestro formulario
        messages: {
            txtNombre: {
              required: "Campo requerido.",
              texto_con_espacios: "Texto no válido.",
              remote: "Ya existe el rol."
            },
            txtDescripcion: {
              texto_direccion: "Texto no válido."
            }
        },
        // Le agregamo clase de error al elemento si existiera alguno
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        // Quitamos clase de error al elemento si tenía algún error
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
          errorElement: 'span',
          errorClass: 'help-block label-error',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function() {
            // Preparamos las variables a enviar via ajax y desabilitamos el formulario
            var formData = new FormData(formAlta[0]);
            //formAlta.find("#fieldset-form").attr("disabled", true);
            $("#btnNuevo").html('Guardando <i class="icon-spinner9 spinner"></i>');
            
            // Enviamos información via ajax
            $.ajax({
              type: "POST",  
              url: "config.php",
              data: formData,
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              success: function(respuesta) {
                // Recargamos los valores de la tabla
                if(!respuesta.error) {
                  notificacionTiempo("¡ÉXITO!", "Se registró correctamente el empleado.", "success", 2000);
                  // Validamos el retorno para mostrar mensajes de STATUS
                  $('#tabla-datos').DataTable().ajax.reload();
                } else {
                  if(respuesta.tipo == "privilegios") {
                    notificacionConfirmar("Error", "No tienes privilegios para realizar ésta acción.", "error");
                  } else {
                    notificacionConfirmar("Error", "Se produjo un error en tiempo de ejecición.", "error");
                  }
                }
                
                // Cambiamos valores de etiqueta del botón, activamos el formulario deshabilitado y ocultamos el modal
                $("#btnNuevo").html('Guardar');
                formAlta.find("#fieldset-form").attr("disabled", false);
                $("#modal-alta").modal("hide");
              }
            });
            
        }
    });
    
    
    
   /*
    *  Código para modificar
    */

   /*
    *  Buscar información para modificar
    */
    
  $("#modal-modificar").on("shown.bs.modal", function() {
    formModificar.find("#txtNombre").focus();
  });
    
  /*
   * Formulario Modificar
   */
  
  formModificar.on("submit", function(evt) {
    evt.preventDefault();
  }).validate({
        // Quitamos valores del inicio o final que sean espacios
        normalizer: function( value ) {
          return $.trim( value );
        },
        // Establecemos las reglas de nuestro formulario
        rules: {
            txtNombre: {
              required: true,
              texto_con_espacios: true,
              remote: {
                url: "config.php",
                type: "post",
                data: {
                  action: "existe-roles",
                  txtNombreActual: function() {
                    return $("#txtNombreActual").val();
                  }
                }
              }
            },
            txtDescripcion: {
              texto_direccion: true,
            },
        },
        // Establecemos los mensajes de error para las reglas de nuestro formulario
        messages: {
            txtNombre: {
              required: "Campo requerido.",
              texto_con_espacios: "Texto no válido.",
              remote: "Ya existe el rol."
            },
            txtDescripcion: {
              texto_direccion: "Texto no válido."
            }
        },
        // Le agregamo clase de error al elemento si existiera alguno
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        // Quitamos clase de error al elemento si tenía algún error
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
          errorElement: 'span',
          errorClass: 'help-block label-error',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function() {
          // Ejecutamos la función de confirmar acción para poder proseguir con la modificación
          confirmarAccion("Confirmacion", "¿Desea modificar los datos del rol?", "warning", modificar, 0);
        }
    });
    
    $.ajax({
      type: "POST",  
      url: "config.php",
      // Preparamos valores para enviar
      data: {
        action: "get-permisos",
        modulo: "modulo-roles"
      },
      dataType: "json",
      cache: false,
      success: function(respuesta) {
        permisos = respuesta;
      }
    });

    mostrarTabla();
});

  /*
   *  Creacion y asignacion de variables generales
   */
  var formModificar = $("#form-modificar");
  var formAlta = $("#form-alta");

  /*
   *  Función para mostrar los datos de la tabla
   */
  function mostrarTabla() {
    var objTablaDatos = $('#tabla-datos').DataTable({
        processing: true,
        serverSide: true,
        // Mandamos el evento por ajax al servidor
        ajax: {
          type: "POST",
          url: "config.php",
          data: function ( d ) {
                // Retorna valor para envio al servidor
                d.action = "tabla-roles";
            }
        },
        // Asignación de datos a columnas
        "columns": [
            { "data": "nombre"},
            { "data": "descripcion"},
            {
              // Generamos botones botones para las acciones dentro de la tabla
              sortable: false,
              "render": function ( data, type, full, meta ) {
                
                btnModificar = "";
                btnEliminar = "";

                if(permisos[1] == 1) {
                  btnEliminar = '<button type="button" class="btn btn-icon btn-danger btn-sm btnEliminarTabla" data-toggle="tooltip" data-placement="right" title="Eliminar" data-original-title="Eliminar"><i class="icon-trash-o"></i></button>';
                }

                if(permisos[2] == 1) {
                  btnModificar = '<button type="button" class="btn btn-amber btn-sm btnModificarTabla" data-toggle="tooltip" data-placement="left" title="Modificar" data-original-title="Modificar"><i class="icon-pencil3"></i></button>';
                }

                return '<div class="btn-group">'+
                            btnModificar+
                            btnEliminar+
                        '</div>';

                  /*return '<div class="btn-group">'+
                                        '<button type="button" class="btn btn-amber btn-sm btnModificarTabla"><i class="icon-pencil3"></i></button>'+
                                        '<button type="button" class="btn btn-icon btn-danger btn-sm btnEliminarTabla" data-toggle="tooltip" data-placement="right" title="Eliminar" data-original-title="Eliminar"><i class="icon-trash-o"></i></button>'+
                                    '</div>';*/
                  
              }
            }
        ],
        // Cambiamos lenguaje de la tabla
        language: {
            lengthMenu: "Registros por página _MENU_",
            zeroRecords: "No se encontraron datos",
            searchPlaceholder: "Buscar",
            info: "Mostrando registros de _START_ al _END_ de un total de _TOTAL_",
            infoEmpty: "No se encontraron datos",
            infoFiltered: "(Filtrando de un total de _MAX_ registros)",
            search: "Buscar:",
            paginate: {
                first: "|<",
                last: ">|",
                next: "Sig.",
                previous: "Ant."
            },
            loadingRecords:		"Cargando...",
            processing:			"Procesando...",
        },
        lengthMenu:				[[10, 20, 30], [10, 20, 30]],
        dom: '< "row" <"top col-sm-6" <"container-controls-table"f> > <"top col-sm-6"l>rt<"bottom col-sm-6"i><"bottom col-sm-6"p><"clear"> >'
        
    });
    
    // Generamos metodo para las acciones de la tabla
    action(objTablaDatos);
  }
  
  /*
   *  Creamos metodo para modificar via ajax con la base de datos
   */
  function modificar() {
    
    // Asociamos variables para mandar al formulario, desabilitamos el formulario y cambiamos etiqueta del botón
    var formData = new FormData(formModificar[0]);
    formModificar.find("#fieldset-form").attr("disabled", true);
    $("#btnModificar").html('Guardando <i class="icon-spinner9 spinner"></i>');
    
    // Enviamos la petición y la información via ajax
    $.ajax({
      type: "POST",  
      url: "config.php",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta) {
        // Validamos el retorno para mostrar mensajes de STATUS
        if(!respuesta.error) {
          notificacionTiempo("¡ÉXITO!", "Se modificó correctamente el empleado.", "success", 2000);
          // Recargamos los valores de la tabla// Validamos el retorno para mostrar mensajes de STATUS
          $('#tabla-datos').DataTable().ajax.reload();
        } else {
          if(respuesta.tipo == "privilegios") {
            notificacionConfirmar("Error", "No tienes privilegios para realizar ésta acción.", "error");
          } else {
            notificacionConfirmar("Error", "Se produjo un error en tiempo de ejecición.", "error");
          }
        }
        
        // Cambiamos valores de etiqueta del botón, activamos el formulario deshabilitado y ocultamos el modal
        $("#btnModificar").html('Modificar');
        formModificar.find("#fieldset-form").attr("disabled", false);
        $("#modal-modificar").modal("hide");
      }
    });
  }
  
  /*
   *  Creamos metodo para eliminar registro / baja lógica
   */
  function eliminar(dato) {
    $.ajax({
      type: "POST",  
      url: "config.php",
      // Preparamos valores para enviar
      data: {
        action: "eliminar-roles",
        mydata: dato
      },
      dataType: "json",
      cache: false,
      success: function(respuesta) {
        // Validamos el retorno para mostrar mensajes de STATUS
        if(!respuesta.error) {
          notificacionTiempo("¡ÉXITO!", "Se eliminó correctaoemnte de nomina al usuario.", "success", 2000);
          // Recargamos los valores de la tabla
          $('#tabla-datos').DataTable().ajax.reload();
        } else {
          if(respuesta.tipo == "no-eliminar") {
            notificacionConfirmar("Error", "No se puede eliminar porque tienes asociado a uno o más Usuarios con el rol.", "error");
          } else if(respuesta.tipo == "privilegios") {
            notificacionConfirmar("Error", "No tienes privilegios para realizar ésta acción.", "error");
          } else {
            notificacionConfirmar("Error", "Se produjo un error en tiempo de ejecición.", "error");
          }
        }
        
        // Cambiamos valores de etiqueta del botón, activamos el formulario deshabilitado y ocultamos el modal
        $("#btnModificar").html('Modificar');
        formModificar.find("#fieldset-form").attr("disabled", false);
        $("#modal-modificar").modal("hide");
      }
    });
  }
  
  function action(table) {
    
    // Le asignamos el evento click a botones de la tabla
    $("tbody").on("click", "button.btnModificarTabla",function() {
      // Quitamos eventos click para garantizar que sólo se ejecute una vez dicho evento
      $(this).off("click");
      // Obtenemos valores de la tabla desde el metodo data y la asignamos a variables
      var data = table.row($(this).parents("tr")).data();
      var dat = data.id;
      
      // Reseteamos valores del formulario y el modal (validacion, limpiar formulario y botones)
      formModificar.validate().resetForm();
      formModificar.find(".form-group").removeClass("has-error");
      formModificar.find("#fieldset-form").attr("disabled", false);
      formModificar[0].reset();
      $("#btnModificar").html('Modificar');
      
      // Enviamos petición y valores via ajax al servidor, no se usa de la propiedad de la tabla porque los datos no están completos
      $.ajax({
        url: "config.php",
        type: "post",
        dataType: "json",
        cache: false,
        data: {
            action: "datos-roles",
            x: dat
        },
        success: function(respuesta) {
            // Validamos el retorno para mostrar mensajes de STATUS
            if(!respuesta.error) {
              // Seteamos los valores devueltos via ajax del servidor y se los asignamos a los elementos del formulario
              formModificar.find("#txtNombre").val(respuesta.nombre);
              formModificar.find("#txtNombreActual").val(respuesta.nombre);
              formModificar.find("#txtDescripcion").val(respuesta.descripcion);
              formModificar.find("#tabla-privilegios-modal").children("tbody").html(respuesta.bodyTable	);
              formModificar.find("#xDato").val(dat);
              
              // Mostramos el modal donde está el formulario de modificar
              $("#modal-modificar").modal({
                  backdrop: "static",
                  keyboard: false
              });
              
            } else {
              if(respuesta.tipo == "privilegios") {
                notificacionConfirmar("Error", "No tienes privilegios para realizar ésta acción.", "error");
              } else {
                notificacionConfirmar("Error", "Se produjo un error en tiempo de ejecición.", "error");
              }
            }
            
        }
      });
    });
    
    $("tbody").on("click", "button.btnEliminarTabla", function() {
      // Quitamos eventos click para garantizar que sólo se ejecute una vez dicho evento
      $(this).off("click");
      // Obtenemos valores de la tabla desde el metodo data y la asignamos a variables
      var data = table.row($(this).parents("tr")).data();
      var dat = data.id, nombre = data.nombre;
      // Validamos que tipo de botón es para poder mostrar el mensaje de confirmacion y la accion a realizar
      confirmarAccion("Confirmacion", "¿Desea eliminar el rol "+nombre+"?", "warning", eliminar, dat);
    });
    
    // Agregamos clase a paginación de la tabla para que se vuelva más pequeños
    $('#tabla-datos_wrapper').find("#tabla-datos_paginate").addClass("pagination-sm");
  }
  
  