$(document).ready(function () {
    //Convertir a mayúsculas al presionar la tecla
    $(".press-mayusculas").on("keypress", function () {
        $input = $(this);
        setTimeout(function () {
            $input.val($input.val().toUpperCase());
        })
    });

    //Convertir a minúscula al presionar la tecla
    $(".press-minusculas").on("keypress", function () {
        $input = $(this);
        setTimeout(function () {
            $input.val($input.val().toLowerCase());
        })
    });

    //Permitir presionar unicamente las teclas de mayúsculas, minúsculas y números
    $('.key-letras-numeros').keypress(function (tecla) {
        if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90)) return false;
    });

    //Permitir presionar unicamente mayúsculas
    $('.only-mayusculas').keypress(function (tecla) {
        if (tecla.charCode < 65 || tecla.charCode > 90) return false;
    });

    //Permitir presionar unicamente minúsculas
    $('.only-minusculas').keypress(function (tecla) {
        if (tecla.charCode < 97 || tecla.charCode > 122) return false;
    });

    //Permitir presionar unicamente números
    $('.only-numeros').keypress(function (tecla) {
        if ((tecla.charCode < 48 || tecla.charCode > 57)) return false;
    });

    //Permitir presionar caracteres no numéricos (mayúsculas, minúsculas, tildes, ñ, etc)
    $('.only-letras').keypress(function (tecla) {
        if (tecla.charCode > 47 && tecla.charCode < 58) return false;
    });
});
