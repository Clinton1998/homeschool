$(document).ready(function () {

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

    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
        // Enable finish button only on last step
        if (stepNumber == 3) {
            $('.btn-finish').removeClass('disabled');
        } else {
            $('.btn-finish').addClass('disabled');
        }
    });

});

function fxConfirmacionEliminarAlumno(id_alumno) {
    swal({
        title: '',
        text: "Está seguro(a) de eliminar el registro?",
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then(function () {
        fxEliminarAlumno(id_alumno);
    }, function (dismiss) {});

}

function fxEliminarAlumno(id_alm) {
    var l = Ladda.create(document.getElementById('btnEliminarAlumno' + id_alm));
    l.start();
    $.ajax({
        type: 'POST',
        url: '/super/alumno/eliminar',
        data: {
            id_alumno: id_alm
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
