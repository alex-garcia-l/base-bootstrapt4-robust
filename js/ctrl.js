$(document).on("ready", function() {
    
    $(this).on("click", "a", function(evt) {
        if($(this).attr("href")=="#" || $(this).attr("href")=="") {
            evt.preventDefault();
        }
    });
    
    $('a[data-action="expand"]').on('click',function(e){
        e.preventDefault();
        $(this).closest('.card').find('[data-action="expand"] i').toggleClass('icon-expand2 icon-contract');
        $(this).closest('.card').toggleClass('card-fullscreen');
    });
  
    $(this).on("submit", "form", function(evt) {
        if($(this).attr("action") == "" || $(this).attr("action") == undefined) {
            evt.preventDefault();
        }
    });
    
    /*positionFix();
    
    $(this).on("click", ".paginate_button > .page-link", function(evt) {
        alert("ok");
        positionFix();
    })
    
    function positionFix() {
        tamPantalla = $(window).height();
        heightPage = $(document).height();
    
        if(heightPage <= tamPantalla) {
            $(".footer").removeClass("footer-static");
            $(".footer").addClass("navbar-fixed-bottom");
        } else {
            $(".footer").removeClass("navbar-fixed-bottom");
            $(".footer").addClass("footer-static");
        }
    }*/


    //$('.my-tooltip').tooltip();
   
});

// Creamos evento para confirmacón de alguna acción, funcionEjecutar es la función para ejecutar si
  // acepta la confirmacion y el daton es algún registro en particular
  function confirmarAccion(titulo, texto, icono, funcionEjecutar, dato) {
    // Creamos nuestro alerta de sweetalert
    swal({
        title: titulo,
        text: texto,
        icon: icono,
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
      .then(function (isConfirm) {
        // Verificamos si se confirmo para poder realizar un evento
        if (isConfirm) {
          // Validamos si el valor de dato es igual a cero, si no lo tiene mandamos a ejecutar
          // la función sin argumento (por ejemplo modificar), de lo contrario ejecutamos con argumento
          if(dato == 0) {
            funcionEjecutar();
          } else {
            funcionEjecutar(dato);
          }
            
        }
      });
      
  }
  
  // Creamos evento para mostrar notificación sin tiempo
  function notificacionConfirmar(titulo, texto, icono) {
    swal({
      title: titulo,
      text: texto,
      icon: icono,
      dangerMode: true,
      button: "Aceptar",
      closeOnClickOutside: false,
    });
  }
  
  // Creamos evento para mostrar notificación con tiempo
  function notificacionTiempo(titulo, texto, icono, tiempo) {
    swal({
      title: titulo,
      text: texto,
      icon: icono,
      dangerMode: true,
      buttons: false,
      closeOnClickOutside: false,
      timer: tiempo,
    });
  }