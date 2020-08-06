/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('notificacion', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        notificaciones: [],
    },
    created() {
        if (window.Laravel.userId) {
            //recuperar las notificaciones no leidas
            axios.post('/notificacionesdelusuario').then((response) => {
                this.notificaciones = response.data;
            });
            //estar pendiente de nuevas notificaciones
            Echo.private('App.User.' + window.Laravel.userId).notification((response) => {
                var data = {
                    "id": response.id,
                    "data": {
                        "notificacion": response.notificacion
                    },
                    "created_at": 'Reciente'
                };
                this.notificaciones.unshift(data);

                if (response.notificacion.tipo == 'comunicado') {
                    $('#tituloShowComunicado').text(response.notificacion.comunicado.c_titulo);
                    $('#descripcionShowComunicado').text(response.notificacion.comunicado.c_descripcion);
                    if (response.notificacion.comunicado.c_url_archivo != null) {
                        var htmlArchivos = '<span class="d-block"><a href="/comunicado/archivo/' + response.notificacion.comunicado.id_comunicado + '/' + response.notificacion.comunicado.c_url_archivo + '" class="text-primary" cdownload="' + response.notificacion.comunicado.c_url_archivo + '">Descargar Archivo ' + response.notificacion.comunicado.c_url_archivo + '</a></span>';
                        $.each(response.notificacion.comunicado.archivos, function(indice, archivo) {
                            htmlArchivos += '<span class="d-block"><a href="/comunicado/archivo/' + response.notificacion.comunicado.id_comunicado + '/' + archivo.c_url_archivo + '" class="text-primary" cdownload="' + archivo.c_url_archivo + '">Descargar Archivo ' + archivo.c_url_archivo + '</a></span>';
                        });
                        $('#archivoShowComunicado').html(htmlArchivos);
                    } else {
                        $('#archivoShowComunicado').text('');
                    }
                    $('#mdlShowComunicado').modal('show');
                } else {
                    Push.create(response.notificacion.titulo, {
                        body: response.notificacion.mensaje,
                        icon: '/assets/images/Logo-HS.png',
                        timeout: 30000,
                        vibrate: [200, 100],
                        onClick: function() {
                            this.close();
                        }
                    });
                }
            });

            //estas pendiente si se ha leido una notificacion
            Echo.private(`newnotificationread.${window.Laravel.userId}`).listen("NotificationRead", e => {
                for (var i = 0; i < this.notificaciones.length; i++) {
                    if (this.notificaciones[i].id == e.notification.id) {
                        this.notificaciones.splice(i, 1);
                    }
                }
            });

            //cuando hay nuevos mensajes para grupos
            Echo.private(`alertforuser.${window.Laravel.userId}`).listen(
                "AlertSimple",
                e => {
                    var alert = e.alert;
                    VanillaToasts.create({
                        title: alert.title,
                        text: alert.text,
                        type: alert.type,
                        icon: alert.icon,
                        positionClass: 'bottomCenter',
                        timeout: alert.timeout
                    });
                }
            );

            Echo.private(`newnumberforvoucher.${window.Laravel.userId}`).listen(
                "NumberVoucherCreated",
                e => {
                    let serie_interfaz = parseInt($('#inpIdSerieParaComprobante').val());
                    if (serie_interfaz == e.id_serie) {
                        $('#spnNumeroParaSerie').text(e.next_number);
                    }
                }
            );
        }
    }
});