<template>
   
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-primary">{{notificaciones.length}}</span>
                <i class="i-Bell text-muted header-icon"></i>
            </div>
            
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">

                <div class="dropdown-item d-flex" v-for="notificacion in notificaciones">
                    <div class="notification-icon">
                        <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>{{notificacion.data['notificacion']['titulo']}}</span>
                            <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">{{notificacion.created_at}}</span>
                        </p>
                        <p class="text-small text-muted m-0">{{notificacion.data['notificacion']['mensaje']}}</p>
                    </div>
                </div>
                
            </div>
        </div>
        
</template>

<script>
    export default {
        props: ['notificaciones']
    }
</script>