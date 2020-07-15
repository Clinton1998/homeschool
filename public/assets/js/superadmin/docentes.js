$(document).ready(function () {
    $('#tabla').DataTable({
        //paging: false,
        //"bInfo" : false
    });
    new SlimSelect({
        select: '#optsecciones',
        placeholder: 'Elige secciones',
        onChange: (info) => {
            fxArmar(info);
        }
    });

    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Registrar')
        .addClass('btn btn-primary')
        .on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var elmForm = $("#myForm");
                if (elmForm) {
                    elmForm.validator('validate');
                    var elmErr = elmForm.find('.has-error');
                    if (elmErr && elmErr.length > 0) {
                        alert('Vaya, todavía tenemos datos que llenar en el formulario');
                        return false;
                    } else {
                        elmForm.submit();
                        return false;
                    }
                }
            }
        });
    var btnCancel = $('<button></button>').text('Cancelar')
        .addClass('btn btn-danger')
        .on('click', function () {
            $('#smartwizard').smartWizard("reset");
            $('#myForm').find("input, textarea,select").val("");
            $('#bd-example-modal-lg').modal('hide');
        });



    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'default',
        transitionEffect: 'fade',
        toolbarSettings: {
            toolbarPosition: 'bottom',
            toolbarExtraButtons: [btnCancel, btnFinish]
        },
        lang: {
            next: 'Siguiente',
            previous: 'Anterior'
        },
        anchorSettings: {
            markDoneStep: true, // add done css
            markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
            removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
        }
    });

    $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
        var elmForm = $("#form-step-" + stepNumber);
        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
        if (stepDirection === 'forward' && elmForm) {
            elmForm.validator('validate');
            var elmErr = elmForm.children('.has-error');
            if (elmErr && elmErr.length > 0) {
                // Form validation failed
                return false;
            }
        }
        return true;
    });

    /*$("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
        // Enable finish button only on last step
        if (stepNumber == 3) {
            $('.btn-finish').removeClass('disabled');
        } else {
            $('.btn-finish').addClass('disabled');
        }

        console.log('Step number es: ',stepNumber);
    });*/

});

function fxArmar(secciones) {

    if (secciones.length > 0) {
        var datos = {
            secciones: secciones
        };
        $.ajax({
            type: 'POST',
            url: '/docente/seccion/cursos',
            data: datos,
            error: function (error) {
                alert('Ocurrió un error');
                console.error(error);
            }
        }).done(function (data) {
            var htmlCursos = '';

            data.forEach(function (seccion, index) {
                var grado = seccion.grado;
                htmlCursos += '<div id="divSeccion' + seccion.id_seccion + '">';
                htmlCursos += '<h4 class="text-primary">' + grado.c_nivel_academico + ' ' + (grado.c_nombre.substr(3)) + ' "' + seccion.c_nombre + '"</h4>';
                htmlCursos += '<div class="form-group">';
                htmlCursos += '<select id="optcursos' + seccion.id_seccion + '" name="optcursos' + seccion.id_seccion + '[]" class="cursosdeseccion" multiple>';
                seccion.categorias.forEach(function (categoria, indice) {
                    htmlCursos += '<option value="' + categoria.id_categoria + '">' + categoria.c_nombre + '</option>';
                });
                htmlCursos += '</select>';
                htmlCursos += '</div>';
                htmlCursos += '</div>';
            });
            $('#divCursos').html(htmlCursos);
            for (var i = 0; i < secciones.length; i++) {
                new SlimSelect({
                    select: '#optcursos' + secciones[i]['value']
                });
            }
        });
    } else {
        $('#divCursos').html('');
    }
}

function fxEliminarDocente(id_doc) {
    var l = Ladda.create(document.getElementById('btnEliminarDocente' + id_doc));
    l.start();
    $.ajax({
        type: 'POST',
        url: '/super/docente/eliminar',
        data: {
            id_docente: id_doc
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
            l.stop();
        }
    }).done(function (data) {
        if (data.correcto) {
            location.reload();
        }
    });
}


function fxConfirmacionEliminarDocente(id_docente) {
    swal({
        title: '',
        text: "Está seguro(a) de eliminar el registro?",
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then(function () {
        fxEliminarDocente(id_docente);
    }, function (dismiss) {});

}
