$(document).ready(function() {
    $('.borrar2').unbind().click(function() {
        var $button = $(this);

        var row = $(this).parents('tr');
        var $form = $(this).parents('form');
        var $url = $form.attr('action');
        var $dat = $form.serialize();
        var $method = $form.attr('method');

        var data_nombre = $button.attr('data-nombre');

        Swal.fire({

                title: "¿Seguro que deseas continuar?",
                text: "Eliminar : " + data_nombre + ", no podrás deshacer este paso.",
                icon: "warning",
                cancelButtonClass: 'btn btn-danger',
                confirmButtonClass: 'btn btn-success',
                cancelButtonColor: '#DD6B55',
                confirmButtonColor: '#3085d6',
                confirmButtonText: "¡Aceptar!",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: false,
                customClass: 'swal-wide',
            })
            .then((value) => {
                if (value.isConfirmed) {
                   $form.submit();
                } else {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        title: "Cancelado",
                        icon: 'error',
                        title: 'Se canceló la eliminación :)',
                        customClass: 'swal-pop',
                    })

                }
                // $button.children('i').attr('class', 'fa fa-trash').removeAttr('disabled');


            });

        return false;
    })
});