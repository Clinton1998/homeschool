<template>
    <div class="chat">
            <div class="chat-header">
                <template v-if="contact">
                    <div class="chat-header-user">
                        <figure class="avatar avatar-lg">
                            <img src="https://via.placeholder.com/150" class="rounded-circle">
                        </figure>
                        <div>
                            <h5>{{contact.email}}</h5>
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