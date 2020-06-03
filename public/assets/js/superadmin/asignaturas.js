$(document).ready(function () {

    ActivarSelect();

    $('#hs_aside_cursos').hide();
    $('#hs_separator').show();

    $('#btn_update_asignatura').hide();

    tbl_asignaturas = $("#tbl_asignaturas").DataTable({

        "dom": 'tp',
        "order": [
            [3, "desc"]
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
                "defaultContent": "<div class='text-center'><a href='#' class='badge badge-warning btn_edit_asignatura' data-toggle='tooltip' data-placement='top' title='Editar' data-original-title='Editar'><i class='i-Pen-5' style='font-size: 17px'></i></a> &nbsp; <a href='#' class='badge badge-danger btn_del_asignatura' data-toggle='tooltip' data-placement='top' title='Eliminar' data-original-title='Eliminar'><i class='far fa-trash-alt' style='font-size: 17px; color: whitesmoke'></i></a></div>"
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
                "data": "nom_categoria",
            },
            {
                "data": "nom_grado",
                "render": function (data, type, row, meta) {

                    n = data.charAt(0);
                    data_cut = data.substr(3, 10)

                    //return '<span>' + data + "-" + n + data_cut + '</span>';
                    return '<span>' + n + data_cut + '</span>';
                }
            },
            {
                "data": "nom_seccion"
            },
            {
                "defaultContent": "<div class='text-center'><a href='#' class='btn_edit_asi_sec badge badge-warning' data-toggle='tooltip' data-placement='top' title='Editar' data-original-title='Editar'><i class='i-Pen-5' style='font-size: 17px'></i></a>&nbsp;<a href='#' class='btn_del_asi_sec badge badge-danger' data-toggle='tooltip' data-placement='top' title='Eliminar' data-original-title='Eliminar'><i class='far fa-trash-alt' style='font-size: 17px; color: whitesmoke'></i></a></div>"
            },
            {
                "defaultContent": "<div><a href='#' class='badge badge-info' onclick='fxDocentesDeCurso(event);'>Docente</a></div>"
            }
        ],
        "order": [
            [4, "asc"]
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
                "data": "nom_grado",
                "render": function (data, type, row, meta) {
                    n = data.charAt(0);
                    data_cut = data.substr(3, 10);
                    u = data_cut.charAt(0).toLocaleUpperCase();
                    data_cut_cut = data_cut.substr(1, 10).toLocaleLowerCase();

                    return '<span>' + n + u + data_cut_cut + '</span>';
                }
            },
            {
                "data": "nom_seccion"
            },
            {
                "defaultContent": "<div class='text-center'><a href='#' class='btn_edit_asig_primaria badge badge-warning' data-toggle='tooltip' data-placement='top' title='Editar' data-original-title='Editar'><i class='i-Pen-5' style='font-size: 17px'></i></a>&nbsp;<a href='#' class='btn_del_asig_primaria badge badge-danger' data-toggle='tooltip' data-placement='top' title='Eliminar' data-original-title='Eliminar'><i class='far fa-trash-alt' style='font-size: 17px; color: whitesmoke'></i></a></div>"
            },
            {
                "defaultContent": "<div><a href='#' class='badge badge-info' onclick='fxDocentesDeCurso(event);'>Docente</a></div>"
            }
        ],
        "order": [
            [4, "asc"]
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
                "data": "nom_grado",
                "render": function (data, type, row, meta) {
                    n = data.charAt(0);
                    data_cut = data.substr(3, 10);
                    u = data_cut.charAt(0).toLocaleUpperCase();
                    data_cut_cut = data_cut.substr(1, 10).toLocaleLowerCase();

                    return '<span>' + n + u + data_cut_cut + '</span>';
                }
            },
            {
                "data": "nom_seccion"
            },
            {
                "defaultContent": "<div class='text-center'><a href='#' class='btn_edit_secundaria badge badge-warning' data-toggle='tooltip' data-placement='top' title='Editar' data-original-title='Editar'><i class='i-Pen-5' style='font-size: 17px'></i></a>&nbsp;<a href='#' class='btn_del_secundaria badge badge-danger' data-toggle='tooltip' data-placement='top' title='Eliminar' data-original-title='Eliminar'><i class='far fa-trash-alt' style='font-size: 17px; color: whitesmoke'></i></a></div>"
            },
            {
                "defaultContent": "<div><a href='#' class='badge badge-info' onclick='fxDocentesDeCurso(event);'>Docente</a></div>"
            }
        ],
        "order": [
            [4, "asc"]
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

    $("#nom_asignatura").val(nom.toLocaleUpperCase());
    $("#color_asignatura").val(col);
});

$(document).on("click", ".btn_del_asignatura", function () {
    fila = $(this);
    id = parseInt($(this).closest('tr').find('td:eq(0)').text());

    swal({
        title: '',
        text: "Está seguro(a) de eliminar el registro?",
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
            if (data.asignaciontodocursos) {
                tbl_inicial.ajax.reload(null, false);
                modal.modal('hide');
                ClearSelects();
                Guardar();
            } else {
                var htmlCursosNoIngresados = '<ul>';
                data.cursosnoasignados.forEach(function (curso, indice) {
                    htmlCursosNoIngresados += '<li>' + curso.c_nombre + '</li>';
                });
                htmlCursosNoIngresados += '</ul>';
                swal({
                    type: 'warning',
                    title: 'Ya existen estos cursos en la seccion seleccionada',
                    html: htmlCursosNoIngresados,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                }).then(function () {
                    location.reload();
                }, function (dismiss) {})
            }
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

            if (data.correcto) {
                tbl_inicial.ajax.reload(null, false);
                mod.modal('hide');
                Actualizar();
            } else {
                alert('Ya existe el curso en esa sección');
                mod.modal('hide');
            }
        },
        error: function (error) {
            alert("Error al guardar");
            console.error(error);
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
        title: '',
        text: "Está seguro(a) de eliminar el registro?",
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
            if (data.asignaciontodocursos) {
                tbl_primaria.ajax.reload(null, false);
                modal.modal('hide');
                Guardar();
            } else {
                var htmlCursosNoIngresados = '<ul>';
                data.cursosnoasignados.forEach(function (curso, indice) {
                    htmlCursosNoIngresados += '<li>' + curso.c_nombre + '</li>';
                });
                htmlCursosNoIngresados += '</ul>';
                swal({
                    type: 'warning',
                    title: 'Ya existen estos cursos en la seccion seleccionada',
                    html: htmlCursosNoIngresados,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                }).then(function () {
                    location.reload();
                }, function (dismiss) {})
            }
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
            if (data.correcto) {
                tbl_primaria.ajax.reload(null, false);
                mod.modal('hide');
                Actualizar();
            } else {
                alert('Ya existe el curso en esa sección');
                mod.modal('hide');
            }

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
        title: '',
        text: "Está seguro(a) de eliminar el registro?",
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
            if (data.asignaciontodocursos) {
                tbl_secundaria.ajax.reload(null, false);
                modal.modal('hide');
                Guardar();
            } else {
                var htmlCursosNoIngresados = '<ul>';
                data.cursosnoasignados.forEach(function (curso, indice) {
                    htmlCursosNoIngresados += '<li>' + curso.c_nombre + '</li>';
                });
                htmlCursosNoIngresados += '</ul>';
                swal({
                    type: 'warning',
                    title: 'Ya existen estos cursos en la seccion seleccionada',
                    html: htmlCursosNoIngresados,
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-warning'
                }).then(function () {
                    location.reload();
                }, function (dismiss) {})
            }
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
            if (data.correcto) {
                tbl_secundaria.ajax.reload(null, false);
                mod.modal('hide');
                Actualizar();
            } else {
                alert('Ya existe el curso en esa sección');
                mod.modal('hide');
            }
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
        title: '',
        text: "Está seguro(a) de eliminar el registro?",
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

function fxDocentesDeCurso(e) {
    e.preventDefault();
    $('#docentes_inicial').modal('show');
    //obtenemos la fila
    var fila = $(e.target).parent().parent().parent();
    var td = $(fila.find('td')[0]);
    var seccion_categoria = parseInt(td.text());

    fxConsultarDocentesDelCurso(seccion_categoria);
};

function fxConsultarDocentesDelCurso(seccion_categoria) {
    $('#spinnerInfoDocentes').show();
    $('#divDocentes').attr('style', 'display: none;');
    $.ajax({
        type: 'POST',
        url: '/super/categoria/docentes',
        data: {
            id_seccion_categoria: seccion_categoria
        },
        error: function (error) {
            alert('Ocurrió un error');
            console.error(error);
        }
    }).done(function (data) {
        if (data.correcto) {
            var htmlDocentes = ``;
            data.docentes.forEach(function (docente, indice) {
                htmlDocentes += `
                    <div class="card_list">
                        <div class="card_list_fotografia">`;
                var srcFoto = '';
                if (docente.c_foto == null) {
                    if (docente.c_sexo.toUpperCase() == 'M') {
                        srcFoto = '../assets/images/usuario/teacherman.png';
                    } else {
                        srcFoto = '../assets/images/usuario/teacherwoman.png';
                    }
                } else {
                    srcFoto = '../super/docente/foto/' + docente.c_foto;
                }

                htmlDocentes += `<img class="card_list_fotografia_img" src="${srcFoto}" alt="${docente.c_nombre}">`;
                htmlDocentes += `</div>
                        <div class="card_list_datos">
                            <div class="card_list_basico">
                                <div class="card_list_nombre">
                                    <strong class="hs_capitalize">${docente.c_nombre}</strong>
                                </div>
                                <div class="card_list_dni">
                                    <p>DNI: ${docente.c_dni}</p>
                                </div>
                            </div>
    
                            <div class="card_list_contacto">
                                <div class="card_list_telefono">
                                    <strong>Telf.: ${docente.c_telefono}</strong>
                                </div>
                                <div class="card_list_correo">
                                    <p class="card_list_correo_ext">${docente.c_correo}</p>
                                </div>
                            </div>
    
                            <div class="card_list_representante">
                                <div class="card_list_representante_nombre">
                                    <small class="card_list_representante_nombre_block">
                                        <strong>Especialidad:&nbsp;</strong>
                                        <p class="hs_capitalize">${docente.c_especialidad}&nbsp;</p>
                                    </small>
                                </div>
                                <div class="card_list_representante_link">
                                    <a href="/super/docente/${docente.id_docente}" class="card_list_representante_link_more">Más información&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            if (data.docentes.length > 0) {
                $('#divDocentes').html(htmlDocentes);
            } else {
                $('#divDocentes').html('<h3>No hay docentes</h1>');
            }
            $('#spinnerInfoDocentes').attr('style', 'display: none;');
            $('#divDocentes').show();
        } else {
            alert('Ocurrió algun error');
        }
    });
};
// Utilitarios

function Clear() {
    $('#nom_asignatura').val('');
    $('#color_asignatura').val('#ffffff');
    $('#btn_update_asignatura').hide();
    $('#btn_create_asignatura').show();
};

function ActivarSelect() {

    new SlimSelect({
        select: '#asignaturas',
        placeholder: 'Seleccione uno o varios cursos',
        showSearch: false,
    });

    new SlimSelect({
        select: '#asignaturas2',
        placeholder: 'Seleccione uno o varios cursos',
        showSearch: false,
    });

    new SlimSelect({
        select: '#asignaturas3',
        placeholder: 'Seleccione uno o varios cursos',
        showSearch: false,
    });

    new SlimSelect({
        select: '#secciones',
        placeholder: 'Seleccione una o varias secciones',
        showSearch: false,
    });

    new SlimSelect({
        select: '#secciones2',
        placeholder: 'Seleccione una o varias secciones',
        showSearch: false,
    });

    new SlimSelect({
        select: '#secciones3',
        placeholder: 'Seleccione una o varias secciones',
        showSearch: false,
    });
};

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
                asignaturas.append('<option class="hs_capitalize-first" value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignatura.append('<option class="hs_capitalize-first" value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignaturas2.append('<option class="hs_capitalize-first" value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignatura2.append('<option class="hs_capitalize-first" value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignaturas3.append('<option class="hs_capitalize-first" value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
                asignatura3.append('<option class="hs_capitalize-first" value="' + v.id_categoria + '">' + v.c_nombre + '</option>');
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
