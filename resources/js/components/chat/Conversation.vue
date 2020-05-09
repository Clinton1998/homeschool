<template>
    <div class="chat">
            <div class="chat-header">
                <template v-if="contact">
                    <div class="chat-header-user">
                        <figure class="avatar avatar-lg" v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0">
                            <img src="/assets/images/colegio/school.png" class="rounded-circle" v-if="contact.colegio.c_logo==null">
                            <img :src="`/super/colegio/logo/${contact.colegio.c_logo}`" class="rounded-circle" v-else>
                        </figure>
                        <figure class="avatar avatar-lg" v-else-if="contact.id_docente!=null">
                            <template v-if="contact.docente.c_foto==null">
                                <img src="/assets/images/usuario/teacherman.png" class="rounded-circle" v-if="contact.docente.c_sexo=='M'">
                                <img src="/assets/images/usuario/teacherwoman.png" class="rounded-circle" v-else>
                            </template>
                            <img :src="`/super/docente/foto/${contact.docente.c_foto}`" class="rounded-circle" v-else>
                        </figure>
                        <figure class="avatar avatar-lg" v-else-if="contact.id_alumno!=null">
                            <template v-if="contact.alumno.c_foto==null">
                                <img src="/assets/images/usuario/studentman.png" class="rounded-circle" v-if="contact.alumno.c_sexo=='M'">
                                <img src="/assets/images/usuario/studentwoman.png" class="rounded-circle" v-else>
                            </template>
                            <img :src="`/super/alumno/foto/${contact.alumno.c_foto}`" class="rounded-circle" v-else>
                        </figure>


                        <div>
                            <h5 v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0">
                                {{contact.colegio.c_representante_legal}}</h5>
                            <h5 v-if="contact.id_docente!=null">{{contact.docente.c_nombre}}</h5>
                            <h5 v-if="contact.id_alumno!=null">{{contact.alumno.c_nombre}}</h5>
                            <small class="text-muted">
                                <i>Online</i>
                            </small>
                        </div>
                    </div>
                    <div class="chat-header-action">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-success">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-secondary">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-secondary" data-toggle="dropdown">
                                    <i class="ti-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                    <a href="#" class="dropdown-item">Add to archive</a>
                                    <a href="#" class="dropdown-item">Delete</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">Block</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
                <p v-else>
                    Selecciona un usuario
                </p>
            </div>
            <MessagesFeed :contact="contact" :messages="messages" />
    
            <MessageComposer @send="sendMessage"/>
            
        </div>
</template>
<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';
    
    export default{
        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },
        methods: {
            sendMessage(text){
                if(!this.contact){
                    return;
                }
                axios.post('/chat/conversation/send',{
                    contact_id: this.contact.id,
                    text: text
                }).then((response)=> {
                    this.$emit('new',response.data);
                });
            }
        },
        components: {MessagesFeed,MessageComposer}
    }
</script>