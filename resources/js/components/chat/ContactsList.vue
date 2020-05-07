<template>
    <!-- sidebar group -->
    <div class="sidebar-group">

        <!-- Chats sidebar -->
        <div id="chats" class="sidebar active">
            <header>
                <span>Chats</span>
                <ul class="list-inline">
                    <li class="list-inline-item" data-toggle="tooltip" title="New Group" >
                        <a class="btn btn-light" href="#" data-toggle="modal" data-target="#newGroup">
                            <i class="fa fa-users"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-light" data-toggle="tooltip" title="New Chat" href="#" data-navigation-target="friends">
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
                <input type="text" class="form-control" placeholder="Search chat">
            </form>
            <div class="sidebar-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'open-chat': contact== selected }">
                        <div>
                            <figure class="avatar" v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0">
                                <img src="/assets/images/colegio/school.png" class="rounded-circle" v-if="contact.colegio.c_logo==null">
                                <img :src="`/super/colegio/logo/${contact.colegio.c_logo}`" class="rounded-circle" v-else>
                            </figure>
                            <figure class="avatar" v-else-if="contact.id_docente!=null">
                                <template v-if="contact.docente.c_foto==null">
                                        <img src="/assets/images/usuario/teacherman.png" class="rounded-circle" v-if="contact.docente.c_sexo=='M'">
                                        <img src="/assets/images/usuario/teacherwoman.png" class="rounded-circle" v-else>
                                </template>
                                <img :src="`/super/docente/foto/${contact.docente.c_foto}`" class="rounded-circle" v-else>
                            </figure>
                            <figure class="avatar" v-else-if="contact.id_alumno!=null">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>{{contact.email}}</h5>
                            <p>{{contact.ultimo_mensaje}}</p>

                            <div class="users-list-action" v-if="contact.unread">
                                <div class="new-message-count">{{contact.unread}}</div>
                            </div>

                            <div class="users-list-action action-toggle" v-else>
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
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
                <span>Friends</span>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a class="btn btn-light" href="#" data-toggle="modal" data-target="#addFriends">
                            <i class="ti-plus btn-icon"></i> Add Friends
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
                <input type="text" class="form-control" placeholder="Search chat">
            </form>
            <div class="sidebar-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Harrietta Souten</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <span class="avatar-title bg-success rounded-circle">A</span>
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Aline McShee</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Brietta Blogg</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Karl Hubane</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Jillana Tows</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <span class="avatar-title bg-info rounded-circle">AD</span>
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Alina Derington</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <span class="avatar-title bg-warning rounded-circle">S</span>
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Stevy Kermeen</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Stevy Kermeen</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <img src="https://via.placeholder.com/150" class="rounded-circle">
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Gloriane Shimmans</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div>
                            <figure class="avatar">
                                <span class="avatar-title bg-secondary rounded-circle">B</span>
                            </figure>
                        </div>
                        <div class="users-list-body">
                            <h5>Bernhard Perrett</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">Open</a>
                                        <a href="#" data-navigation-target="contact-information" class="dropdown-item">Profile</a>
                                        <a href="#" class="dropdown-item">Add to archive</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ./ Friends sidebar -->

        <!-- Favorites sidebar -->
        <div id="favorites" class="sidebar">
            <header>
                <span>Favorites</span>
                <ul class="list-inline">
                    <li class="list-inline-item d-lg-none d-sm-block">
                        <a href="#" class="btn btn-light sidebar-close">
                            <i class="ti-close"></i>
                        </a>
                    </li>
                </ul>
            </header>
            <form action="">
                <input type="text" class="form-control" placeholder="Search favorites">
            </form>
            <div class="sidebar-body">
                <ul class="list-group list-group-flush users-list">
                    <li class="list-group-item">
                        <div class="users-list-body">
                            <h5>Jennica Kindred</h5>
                            <p>I know how important this file is to you. You can trust me ;)</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">View Chat</a>
                                        <a href="#" class="dropdown-item">Forward</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="users-list-body">
                            <h5>Marvin Rohan</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">View Chat</a>
                                        <a href="#" class="dropdown-item">Forward</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="users-list-body">
                            <h5>Frans Hanscombe</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">View Chat</a>
                                        <a href="#" class="dropdown-item">Forward</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="users-list-body">
                            <h5>Karl Hubane</h5>
                            <p>Lorem ipsum dolor sitsdc sdcsdc sdcsdcs</p>
                            <div class="users-list-action action-toggle">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#">
                                        <i class="ti-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item">View Chat</a>
                                        <a href="#" class="dropdown-item">Forward</a>
                                        <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        

    </div>
</template>

<script>
    export default{
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data(){
            return {
                selected: this.contacts.length ? this.contacts[0]: null
            };
        },
        methods: {
            selectContact(contact){
                this.selected = contact;
                this.$emit('selected',contact);
            }
        },
        computed: {
            sortedContacts(){
                return _.sortBy(this.contacts,[(contact) =>{
                    if(contact==this.selected){
                        return Infinity;
                    }
                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>