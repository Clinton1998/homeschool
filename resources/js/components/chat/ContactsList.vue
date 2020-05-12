<template>
    <!-- sidebar group -->
    <div class="sidebar-group">

        <!-- Chats sidebar -->
        <div id="chats" class="sidebar active">
            <header>
                <span>Conversaciones</span>
                <ul class="list-inline">
                    <li class="list-inline-item" data-toggle="tooltip" title="Nuevo grupo">
                        <a class="btn btn-light" href="#" data-toggle="modal" data-target="#newGroup">
                            <i class="fa fa-users"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-light" data-toggle="tooltip" title="Nueva conversación" href="#"
                            data-navigation-target="friends">
                            <i class="ti-comment-alt"></i>
                        </a>
                    </li>
                    <li class="list-inline-item d-lg-none d-sm-block">
                        <a href="#" class="btn btn-light sidebar-close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
            </header>
            <form action="">
                <input type="text" class="form-control" placeholder="Buscar conversación">
            </form>
            <div class="sidebar-body">
                <ul class="list-group list-group-flush">

                    <!--para las conversaciones grupales-->
                    <li class="list-group-item" v-for="group in groups" :key="group.id" @click="selectGroup(group)" :class="{ 'open-chat': group== selected }">
                            <div class="avatar-group">
                                <figure class="avatar">
                                    <span class="avatar-title bg-warning bg-success rounded-circle">
                                        <i class="fa fa-users"></i>
                                    </span>
                                </figure>
                            </div>
                            <div class="users-list-body">
                                <h5>{{group.name}}</h5>
                                <!--<p><strong>Maher Ruslandi: </strong>Hello!!!</p>-->
                                <div class="users-list-action" v-if="group.unread">
                                <div class="new-message-count">{{group.unread}}</div>
                            </div>
                            </div>
                        </li>
                    <!--para las conversaciones entre usuarios-->
                    <li class="list-group-item" v-for="contact in sortedContacts" :key="contact.id"
                        @click="selectContact(contact)" :class="{ 'open-chat': contact== selected }">
                        <div>
                            <figure :class="`avatar ${(contact.is_online)?'avatar-state-success': ''}`"
                                v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0">
                                <img src="/assets/images/colegio/school.png" class="rounded-circle"
                                    v-if="contact.colegio.c_logo==null">
                                <img :src="`/super/colegio/logo/${contact.colegio.c_logo}`" class="rounded-circle"
                                    v-else>
                            </figure>
                            <figure :class="`avatar ${(contact.is_online)?'avatar-state-success': ''}`" v-else-if="contact.id_docente!=null">
                                <template v-if="contact.docente.c_foto==null">
                                    <img src="/assets/images/usuario/teacherman.png" class="rounded-circle"
                                        v-if="contact.docente.c_sexo=='M'">
                                    <img src="/assets/images/usuario/teacherwoman.png" class="rounded-circle" v-else>
                                </template>
                                <img :src="`/super/docente/foto/${contact.docente.c_foto}`" class="rounded-circle"
                                    v-else>
                            </figure>
                            <figure :class="`avatar ${(contact.is_online)?'avatar-state-success': ''}`" v-else-if="contact.id_alumno!=null">
                                <template v-if="contact.alumno.c_foto==null">
                                    <img src="/assets/images/usuario/studentman.png" class="rounded-circle"
                                        v-if="contact.alumno.c_sexo=='M'">
                                    <img src="/assets/images/usuario/studentwoman.png" class="rounded-circle" v-else>
                                </template>
                                <img :src="`/super/alumno/foto/${contact.alumno.c_foto}`" class="rounded-circle" v-else>
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5 v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0">
                                {{contact.colegio.c_representante_legal}}</h5>
                            <h5 v-if="contact.id_docente!=null">{{contact.docente.c_nombre}}</h5>
                            <h5 v-if="contact.id_alumno!=null">{{contact.alumno.c_nombre}}</h5>
                            <p>{{contact.ultimo_mensaje}}</p>
                            <div class="users-list-action" v-if="contact.unread">
                                <div class="new-message-count">{{contact.unread}}</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ./ Chats sidebar -->

        <!-- Friends sidebar -->
        <div id="friends" class="sidebar">
            <header>
                <span>Amigos</span>
            </header>
            <form action="">
                <input type="text" class="form-control" placeholder="Search chat">
            </form>
            <div class="sidebar-body">
                <ul class="list-group list-group-flush">

                    <li class="list-group-item" v-for="friend in friends" :key="friend.id"
                        @click="selectContact(friend)" :class="{ 'open-chat': friend== selected }">
                        <div>
                            <figure :class="`avatar ${(friend.is_online)?'avatar-state-success': ''}`"
                                v-if="friend.id_docente==null && friend.id_alumno==null && friend.b_root==0">
                                <img src="/assets/images/colegio/school.png" class="rounded-circle"
                                    v-if="friend.colegio.c_logo==null">
                                <img :src="`/super/colegio/logo/${friend.colegio.c_logo}`" class="rounded-circle"
                                    v-else>
                            </figure>
                            <figure :class="`avatar ${(friend.is_online)?'avatar-state-success': ''}`" v-else-if="friend.id_docente!=null">
                                <template v-if="friend.docente.c_foto==null">
                                    <img src="/assets/images/usuario/teacherman.png" class="rounded-circle"
                                        v-if="friend.docente.c_sexo=='M'">
                                    <img src="/assets/images/usuario/teacherwoman.png" class="rounded-circle" v-else>
                                </template>
                                <img :src="`/super/docente/foto/${friend.docente.c_foto}`" class="rounded-circle"
                                    v-else>
                            </figure>
                            <figure :class="`avatar ${(friend.is_online)?'avatar-state-success': ''}`" v-else-if="friend.id_alumno!=null">
                                <template v-if="friend.alumno.c_foto==null">
                                    <img src="/assets/images/usuario/studentman.png" class="rounded-circle"
                                        v-if="friend.alumno.c_sexo=='M'">
                                    <img src="/assets/images/usuario/studentwoman.png" class="rounded-circle" v-else>
                                </template>
                                <img :src="`/super/alumno/foto/${friend.alumno.c_foto}`" class="rounded-circle" v-else>
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5 v-if="friend.id_docente==null && friend.id_alumno==null && friend.b_root==0">
                                {{friend.colegio.c_representante_legal}}</h5>
                            <h5 v-if="friend.id_docente!=null">{{friend.docente.c_nombre}}</h5>
                            <h5 v-if="friend.id_alumno!=null">{{friend.alumno.c_nombre}}</h5>
                            <p>{{friend.ultimo_mensaje}}</p>
                            <div class="users-list-action" v-if="friend.unread">
                                <div class="new-message-count">{{friend.unread}}</div>
                            </div>
                        </div>
                    </li>


                </ul>
            </div>
        </div>
        <!-- ./ Friends sidebar -->

    </div>
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            },
            friends: {
                type: Array,
                default: []
            },
            groups: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null
            };
        },
        methods: {
            selectContact(contact) {
                this.selected = contact;
                this.$emit('selected', contact,'contact');
            },
            selectGroup(group){
                this.selected = group;
                this.$emit('selected',group,'group')
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity;
                    }
                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>