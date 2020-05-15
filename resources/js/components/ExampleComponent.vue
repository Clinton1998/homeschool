<template>

    <div class="dropdown">
        <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="badge badge-primary">{{notificaciones.length}}</span>
            <i class="i-Bell text-muted header-icon"></i>
        </div>

        <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none"
            aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
            <div class="dropdown-item d-flex" v-on:click="fxMarcarComoLeido(notificacion)"
                v-for="notificacion in notificaciones">
                <div class="notification-icon" v-if="notificacion.data['notificacion']['tipo']=='comunicado'">
                    <i class="i-Receipt-3 text-success mr-1"></i>
                </div>

                <div class="notification-icon" v-else-if="notificacion.data['notificacion']['tipo']=='anuncio'">
                    <i class="i-Speach-Bubble text-primary mr-1"></i>
                </div>

                <div class="notification-icon" v-else>
                    <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                </div>
                <div class="notification-details flex-grow-1">
                    <p class="m-0 d-flex align-items-center">
                        <small>{{notificacion.data['notificacion']['titulo']}}</small>
                        <span class="badge badge-pill badge-primary ml-1 mr-1">nuevo</span>
                        <span class="flex-grow-1"></span>
                    </p>
                    <small class="text-small text-muted ml-auto">{{notificacion.created_at}}</small>
                    <p class="text-small text-muted m-0" style="max-height: 19px; max-width: 150px; overflow: hidden">{{notificacion.data['notificacion']['mensaje']}}</p>
                </div>
            </div>

            <div class="dropdown-divider" v-if="notificaciones.length!=0"></div>
            <div class="dropdown-item" v-on:click="fxMarcarTodoComoLeido()" v-if="notificaciones.length!=0">
                Marcar todo como leido
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        props: ['notificaciones'],
        methods: {
            fxMarcarComoLeido: function (notificacion) {
                //if (notificacion.data.notificacion.tipo == 'comunicado') {
                var data = {
                    id_notification: notificacion.id
                };
                axios.post('/notificacionesdelusuario/marcarcomoleido', data).then((response) => {
                    if (notificacion.data.notificacion.tipo == 'anuncio') {

                        $('#ntf-title').text(notificacion.data.notificacion.titulo);
                        $('#ntf-content').text(notificacion.data.notificacion.mensaje);
                        $('#OPEN-NTF').modal('show');
                    } else if (notificacion.data.notificacion.url != '') {
                        window.location.href = notificacion.data.notificacion.url;
                    }
                });
            },

            fxMarcarTodoComoLeido: function () {
                axios.post('/notificacionesdelusuario/marcartodocomoleido').then((response) => {
                    location.reload();
                });
            }
        }
    }
</script>