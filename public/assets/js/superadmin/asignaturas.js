$(document).ready(function () {

    ActivarSelect();

    $('#hs_aside_cursos').hide();
    $('#hs_separator').show();

    $('#btn_update_asignatura').hide();

    tbl_asignaturas = $("#tbl_asignaturas").DataTable({

        "dom": 'tp',
        "order": [
            [4, "desc"]
        ],
        "ajax": {
            "url": "/super/categorias/read_asignatura",
            "method": 'GET',
            "dataSrc": "",
        },
        "columns": [{
                "data": "id_categoria"
            },
            {
                "data": "c_nombre"
            },
            {
                "data": "c_nivel_academico",
            },
            {
                "data": "created_at"
            },
            {
                "data": "c_nivel_academico",
                "render": function (data, type, row, meta) {
                    return '<input type="color" value="' + data + '" class="Muestra" disabled>';
                }
            },
            {
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-warning btn-sm btn_edit_asignatura' style='margin: 0 5px;'><i class='i-Pen-4'></i></button><button class='btn btn-danger btn-sm btn_del_asignatura' style='margin: 0 5px;'><i class='i-Eraser-2'></i></button></div></div>"
            },
        ]
    });

    tbl_inicial = $("#tbl_inicial").DataTable({

        "ajax": {
            "url": "/super/categorias/read_seccion_categoria",
            "method": 'POST',
            "data": {
                c_nivel_academico: '1'
            },
            "dataSrc": ""
        },
        "columns": [{
                "data": "id_seccion_categoria"
            },
            {
                "data": "id_seccion"
            },
            {
                "data": "id_categoria"
            },
            {
                "data": "nom_categoria"
            },
            {
                "data": "nom_grado"
            },
            {
                "data": "nom_seccion"
            },
            {
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-warning btn-sm btn_edit_asi_sec' style='margin: 0 5px;'><i class='i-Pen-4'></i></button><button class='btn btn-danger btn-sm btn_del_asi_sec' style='margin: 0 5px;'><i class='i-Eraser-2'></i></button></div></div>"
            }
        ]
    });

    tbl_primaria = $("#tbl_primaria").DataTable({

        "ajax": {
            "url": "/super/categorias/read_seccion_categoria",
            "method": 'POST',
            "data": {
                c_nivel_academico: '2'
            },
            "dataSrc": ""
        },
        "columns": [{
                "data": "id_seccion_categoria"
            },
            {
                "data": "id_seccion"
            },
            {
                "data": "id_categoria"
            },
            {
                "data": "nom_categoria"
            },
            {
                "data": "nom_grado"
            },
            {
                "data": "nom_seccion"
            },
            {
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-warning btn-sm btn_edit_asig_primaria' style='margin: 0 5px;'><i class='i-Pen-4'></i></button><button class='btn btn-danger btn-sm btn_del_asig_primaria' style='margin: 0 5px;'><i class='i-Eraser-2'></i></button></div></div>"
            }
        ]
    });

    tbl_secundaria = $("#tbl_secundaria").DataTable({

        "ajax": {
            "url": "/super/categorias/read_seccion_categoria",
            "method": 'POST',
            "data": {
                c_nivel_academico: '3'
            },
            "dataSrc": ""
        },
        "columns": [{
                "data": "id_seccion_categoria"
            },
            {
                "data": "id_seccion"
            },
            {
                "data": "id_categoria"
            },
            {
                "data": "nom_categoria"
            },
            {
                "data": "nom_grado"
            },
            {
                "data": "nom_seccion"
            },
            {
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-warning btn-sm btn_edit_secundaria' style='margin: 0 5px;'><i class='i-Pen-4'></i></button><button class='btn btn-danger btn-sm btn_del_secundaria' style='margin: 0 5px;'><i class='i-Eraser-2'></i></button></div></div>"
            }
        ]
    });
});

// CRUD: Categorias (asignaturas)

var id;

$("#btn_create_asignatura").click(function (e) {
    e.preventDefault();

    nom = $("#nom_asignatura").val();
    col = $("#color_asignatura").val();

    $.ajax({
        type: 'POST',
        url: "/super/categorias/create_asignatura",
        data: {
            c_nombre: nom,
            c_nivel_academico: col
        },
        success: function (data) {
            tbl_asignaturas.ajax.reload(null, false);
            Clear();
            LlenarSelects();
            Guardar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$("#btn_update_asignatura").click(function (e) {
    e.preventDefault();

    nom = $("#nom_asignatura").val();
    col = $("#color_asignatura").val();

    $.ajax({
        type: 'POST',
        url: "/super/categorias/update_asignatura",
        data: {
            id_categoria: id,
            c_nombre: nom,
            c_nivel_academico: col
        },
        success: function (data) {
            tbl_asignaturas.ajax.reload(null, false);
            tbl_inicial.ajax.reload(null, false);
            tbl_primaria.ajax.reload(null, false);
            tbl_secundaria.ajax.reload(null, false);
            Clear();
            LlenarSelects();
            Actualizar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$(document).on("click", ".btn_edit_asignatura", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
    nom = fila.find('td:eq(1)').text();
    col = fila.find('td:eq(2)').text();

    $('#btn_update_asignatura').show();
    $('#btn_create_asignatura').hide();

    $("#nom_asignatura").val(nom);
    $("#color_asignatura").val(col);
});

$(document).on("click", ".btn_del_asignatura", function () {
    fila = $(this);
    id = parseInt($(this).closest('tr').find('td:eq(0)').text());

    swal({
        title: 'Está seguro(a) de eliminar el registro?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result) {
            $.ajax({
                url: "/super/categorias/delete_asignatura",
                type: "POST",
                datatype: "json",
                data: {
                    id_categoria: id
                },
                success: function () {
                    tbl_asignaturas.ajax.reload(null, false);
                    tbl_inicial.ajax.reload(null, false);
                    tbl_primaria.ajax.reload(null, false);
                    tbl_secundaria.ajax.reload(null, false);
                    LlenarSelects();
                    Eliminar();
                }
            });
        }
    })
});

// CRUD: Categorias (asignanturas) - Secciones

// Inicial
$("#btn_asign_inicial").click(function (e) {
    e.preventDefault();

    id_categoria = $("#asignaturas").val();
    id_seccion = $("#secciones").val();
    modal = $('#modal_asign_inicial');

    $.ajax({
        type: 'POST',
        url: "/super/categorias/create_seccion_categoria",
        data: {
            c_nivel_academico: '1',
            id_seccion: id_seccion,
            id_categoria: id_categoria
        },
        success: function (data) {
            tbl_inicial.ajax.reload(null, false);
            modal.modal('hide');
            ClearSelects();
            Guardar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$("#btn_update_inicial").click(function (e) {
    e.preventDefault();

    sec = $("#seccion").val();
    asi = $("#asignatura").val();
    mod = $("#modal_update_inicial");

    $.ajax({
        type: 'POST',
        url: "/super/categorias/update_seccion_categoria",
        data: {
            c_nivel_academico: '1',
            id_seccion_categoria: id,
            id_seccion: sec,
            id_categoria: asi
        },
        success: function (data) {
            tbl_inicial.ajax.reload(null, false);
            mod.modal('hide');
            Actualizar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$(document).on("click", ".btn_edit_asi_sec", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
    sec = fila.find('td:eq(1)').text();
    asi = fila.find('td:eq(2)').text();

    $("#asignatura option[value=" + asi + "]").attr("selected", true);
    $("#seccion option[value=" + sec + "]").attr("selected", true);

    $('#modal_update_inicial').modal('show');
});

$(document).on("click", ".btn_del_asi_sec", function () {
    fila = $(this);
    id = parseInt($(this).closest('tr').find('td:eq(0)').text());

    swal({
        title: 'Está seguro(a) de eliminar el registro?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result) {
            $.ajax({
                url: "/super/categorias/delete_seccion_categoria",
                type: "POST",
                datatype: "json",
                data: {
                    id_seccion_categoria: id
                },
                success: function () {
                    tbl_inicial.ajax.reload(null, false);
                    Eliminar();
                }
            });
        }
    })
});

//Primaria
$("#btn_asign_primaria").click(function (e) {
    e.preventDefault();

    id_categoria = $("#asignaturas2").val();
    id_seccion = $("#secciones2").val();
    modal = $('#modal_asign_primaria');

    $.ajax({
        type: 'POST',
        url: "/super/categorias/create_seccion_categoria",
        data: {
            c_nivel_academico: '2',
            id_seccion: id_seccion,
            id_categoria: id_categoria
        },
        success: function (data) {
            tbl_primaria.ajax.reload(null, false);
            modal.modal('hide');
            Guardar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$("#btn_update_primaria").click(function (e) {
    e.preventDefault();

    sec = $("#seccion2").val();
    asi = $("#asignatura2").val();
    mod = $("#modal_update_primaria");

    $.ajax({
        type: 'POST',
        url: "/super/categorias/update_seccion_categoria",
        data: {
            c_nivel_academico: '2',
            id_seccion_categoria: id,
            id_seccion: sec,
            id_categoria: asi
        },
        success: function (data) {
            tbl_primaria.ajax.reload(null, false);
            mod.modal('hide');
            Actualizar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$(document).on("click", ".btn_edit_asig_primaria", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
    sec = fila.find('td:eq(1)').text();
    asi = fila.find('td:eq(2)').text();

    $("#asignatura2 option[value=" + asi + "]").attr("selected", true);
    $("#seccion2 option[value=" + sec + "]").attr("selected", true);

    $('#modal_update_primaria').modal('show');
});

$(document).on("click", ".btn_del_asig_primaria", function () {
    fila = $(this);
    id = parseInt($(this).closest('tr').find('td:eq(0)').text());

    swal({
        title: 'Está seguro(a) de eliminar el registro?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result) {
            $.ajax({
                url: "/super/categorias/delete_seccion_categoria",
                type: "POST",
                datatype: "json",
                data: {
                    id_seccion_categoria: id
                },
                success: function () {
                    tbl_primaria.ajax.reload(null, false);
                    Eliminar();
                }
            });
        }
    })
});

//Secundaria
$("#btn_asign_secundaria").click(function (e) {
    e.preventDefault();

    id_categoria = $("#asignaturas3").val();
    id_seccion = $("#secciones3").val();
    modal = $('#modal_asign_secundaria');

    $.ajax({
        type: 'POST',
        url: "/super/categorias/create_seccion_categoria",
        data: {
            c_nivel_academico: '3',
            id_seccion: id_seccion,
            id_categoria: id_categoria
        },
        success: function (data) {
            tbl_secundaria.ajax.reload(null, false);
            modal.modal('hide');
            Guardar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$("#btn_update_secundaria").click(function (e) {
    e.preventDefault();

    sec = $("#seccion3").val();
    asi = $("#asignatura3").val();
    mod = $("#modal_update_secundaria");

    $.ajax({
        type: 'POST',
        url: "/super/categorias/update_seccion_categoria",
        data: {
            c_nivel_academico: '3',
            id_seccion_categoria: id,
            id_seccion: sec,
            id_categoria: asi
        },
        success: function (data) {
            tbl_secundaria.ajax.reload(null, false);
            mod.modal('hide');
            Actualizar();
        },
        error: function () {
            alert("Error al guardar");
        }
    });
});

$(document).on("click", ".btn_edit_secundaria", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
    sec = fila.find('td:eq(1)').text();
    asi = fila.find('td:eq(2)').text();

    $("#asignatura3 option[value=" + asi + "]").attr("selected", true);
    $("#seccion3 option[value=" + sec + "]").attr("selected", true);

    $('#modal_update_secundaria').modal('show');
});

$(document).on("click", ".btn_del_secundaria", function () {
    fila = $(this);
    id = parseInt($(this).closest('tr').find('td:eq(0)').text());

    swal({
        title: 'Está seguro(a) de eliminar el registro?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result) {
            $.ajax({
                url: "/super/categorias/delete_seccion_categoria",
                type: "POST",
                datatype: "json",
                data: {
                    id_seccion_categoria: id
                },
                success: function () {
                    tbl_secundaria.ajax.reload(null, false);
                    Eliminar();
                }
            });
        }
    })
});

// Utilitarios

function Clear() {
    $('#nom_asignatura').val('');
    $('#color_asignatura').val('#ffffff');
    $('#btn_update_asignatura').hide();
    $('#btn_create_asignatura').show();
};

function ActivarSelect() {

    new SlimSelect({
        select: '#asignaturas'
    });

    new SlimSelect({
        select: '#asignaturas2'
    });

    new SlimSelect({
        select: '#asignaturas3'
    });

    new SlimSelect({
        select: '#secciones'
    });

    new SlimSelect({
        select: '#secciones2'
    });

    new SlimSelect({
        select: '#secciones3'
    });
}

function LlenarSelects() {
    $.ajax({
        type: 'GET',
        url: "/super/categorias/read_asignatura",
        dataSrc: "",
        success: function (data) {
            var asignaturas = $("#asignaturas");
            asignaturas.find('option').remove();

            var asignatura = $("#asignatura");
            asignatura.find('option').remove();

            var asignaturas2 = $("#asignaturas2");
            asignaturas2.find('option').remove();

            var asignatura2 = $("#asignatura2");
            asignatura2.find('option').remove();

            var asignaturas3 = $("#asignaturas3");
            asignaturas3.find('option').remove();

            var asignatura3 = $("#asignatura3");
            asignatura3.find('option').remove();

            $(data).each(function (i, v) {
                asignaturas.append('<option value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignatura.append('<option value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignaturas2.append('<option value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignatura2.append('<option value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignaturas3.append('<option value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignatura3.append('<option value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
            })
        },
        error: function () {
            alert("Error al leer datos");
        }
    });
};

function ClearSelects() {
    $('#asignaturas').prop("selected", false);
    $('#asignaturas2').prop("selected", false);
    $('#asignaturas3').prop("selected", false);
    $('#secciones').prop("selected", false);
    $('#secciones2').prop("selected", false);
    $('#secciones3').prop("selected", false);
};

// Notificaciones

function Guardar() {
    swal({
        position: 'top-end',
        icon: 'success',
        title: 'Agregado correctamente',
        showConfirmButton: false,
        timer: 1500
    })
};

function Actualizar() {
    swal({
        position: 'top-end',
        icon: 'success',
        title: 'Actualizado correctamente',
        showConfirmButton: false,
        timer: 1500
    })
};

function Eliminar() {
    swal({
        position: 'top-end',
        icon: 'success',
        title: 'Eliminado correctamente',
        showConfirmButton: false,
        timer: 1500
    })
};

// Paleta de colores

$(document).on("click", ".hs_muestra", function () {
    color = $(this).text();
    $("#color_asignatura").val(color);
    $('#modal-color').modal('hide');
});

// Panel de Cursos

$(document).on("click", "#hs_separator", function () {
    $('#hs_aside_cursos').fadeIn();
    $('#hs_separator').hide();
});

$(document).on("click", ".hs_box_close", function () {
    $('#hs_aside_cursos').hide();
    $('#hs_separator').show();
});


/*$(document).on("click", ".btn_del_asignatura", function () {
    fila = $(this);
    id = parseInt($(this).closest('tr').find('td:eq(0)').text());

    var respuesta = confirm("¿Está seguro(a) de eliminar este curso?");

    if (respuesta) {
        $.ajax({
            url: "/super/categorias/delete_asignatura",
            type: "POST",
            datatype: "json",
            data: {
                id_categoria: id
            },
            success: function () {
                tbl_asignaturas.ajax.reload(null, false);
                LlenarSelects();
                Eliminar();
            }
        });
    }
});*/
