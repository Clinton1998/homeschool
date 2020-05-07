<template>
    <div class="chat-body" ref="feed">
        <div class="messages" v-if="contact">
            <!--recibido o enviado-->
            <div v-for="message in messages" :class="`message-item ${message.to == contact.id ? 'outgoing-message': 'recibidoxd'}`" :key="message.id">
                <div class="message-content">
                    {{message.text}}
                </div>
                <div class="message-action">
                    Pm 14:50 <i class="ti-double-check"></i>
                </div>
            </div>
        </div>

        <div class="no-message-container" v-else>
            <i class="fa fa-comments-o"></i>
            <p>Seleccione un chat para leer mensajes.</p>
        </div>
    </div>
</template>

<script>
    export default{
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        methods: {
            scrollToBottom(){
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                },50);
            }
        },
        watch: {
            contact(contact){
                this.scrollToBottom();
            },
            messages(messages){
                this.scrollToBottom();
            }
        }
    }
</script>