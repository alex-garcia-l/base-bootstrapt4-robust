$(document).on("ready", function() {
  
  var formModificar = $("#form-modificar");
  
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
            txtTelefono: {
              integer: true,
              rangelength: [10, 13]
            },
            txtCelular: {
              integer: true,
              rangelength: [10, 13]
            },
            txtCorreo: {
              email: true
            },
          ////////////////////////////////////////////////////////////////////
            txtUser: {
            required: true,
              alphanumeric: true,
              remote: {
                url: "config.php",
                type: "post",
                data: {
                  action: "existe-usuarios",
                  txtUserActual: function() {
                    return $("#txtUsuarioActual").val();
                  }
                }
              }
            },
            txtPass: {
              minlength: 6,
              maxlength: 20
            },
            txtConfirmarPass: {
              equalTo: "#txtPass",
              minlength: 6,
              maxlength: 20
            }
        },
        // Establecemos los mensajes de error para las reglas de nuestro formulario
        messages: {
            txtTelefono: {
              integer: "Admite números.",
              rangelength: "Acepta entre 10 a 13 dígitos."
            },
            txtCelular: {
              integer: "Admite números.",
              rangelength: "Acepta entre 10 a 13 dígitos."
            },
            txtCorreo: {
              email: "Correo incorrecto."
            },
            ////////////////////////////////////////////////////////////////////
            txtUser: {
              required: "Campo requerido.",
              alphanumeric: "Texto no válido.",
              remote: "Ya existe un usuario."
            },
            txtPass: {
              minlength: "Rango a partir de 6 caracteres.",
              maxlength: "Rango a partir de 20 caracteres."
            },
            txtConfirmarPass: {
              equalTo: "Las contraseñas no coincide.",
              minlength: "Rango a partir de 6 caracteres.",
              maxlength: "Rango a partir de 20 caracteres."
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
          swal({
              title: "Confirmación",
              text: "Ingresa tú contraseña actual:",
              icon: "warning",
              content: {
                element: "input",
                attributes: {
                  placeholder: "Contraseña",
                  type: "password",
                },
              },
              // Asignamos botones y lo personalizamos
              buttons: {
                cancel: {
                  text: "Cancelar",
                  value: false,
                  visible: true,
                  className: "btn btn-danger",
                  closeModal: true,
                },
                confirm: {
                  text: "Confirmar",
                  value: true,
                  visible: true,
                  className: "btn btn-green",
                  closeModal: true
                },
              },
              closeOnClickOutside: false,
            })
            .then(function (value) {
              // Verificamos si se confirmo para poder realizar un evento
              
              if(value != "") {
                $.ajax({
                    type: "POST",  
                    url: "config.php",
                    data: {
                      action: "confirmar-password",
                      pass: value
                    },
                    dataType: "json",
                    success: function(respuesta) {
                      // Recargamos los valores de la tabla
                      if(!respuesta.error) {
                        
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
                              notificacionTiempo("¡ÉXITO!", "Se modificó correctamente los datos.", "success", 2000);
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
                            formModificar.find("#txtNombre").attr("disabled", true);
                            formModificar.find("#txtDireccion").attr("disabled", true);
                            formModificar.find("#txtPass").val("");
                            formModificar.find("#txtConfirmarPass").val("");
                            formModificar.find("#txtUsuarioActual").val($("#txtUser").val());
                            $("#modal-modificar").modal("hide");
                          }
                        });
                        
                      } else {
                        if(respuesta.tipo == "contraseña-incorrecta") {
                          notificacionConfirmar("Error", "La contraseña es incorrecta.", "error");
                        } else {
                          notificacionConfirmar("Error", "Se produjo un error en tiempo de ejecición.", "error");
                        }
                      }
                    }
                  });
                }
              
            });
        }
    });
    
});