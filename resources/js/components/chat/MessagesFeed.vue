<template>
  <div class="chat-body" ref="feed">
    <div class="messages" v-if="contact && contact.estado==1">
      <!--recibido o enviado-->
      <div
        v-for="message in messages"
        :class="`message-item ${message.receptor == contact.id ? 'outgoing-message': 'recibidoxd'}`"
        :key="message.id"
      >
        <div class="message-content">{{message.text}}</div>
      </div>
    </div>

    <div class="messages" v-else-if="contact && contact.name">
      <div
        v-for="message in messages"
        :key="message.id" :class="`message-item ${message.user_id == user.id ? 'outgoing-message': 'recibidoxd'}`">
        <strong v-if="message.user_id != user.id && message.nombre_emisor">{{message.nombre_emisor}}</strong>
        <div class="message-content">{{message.message}}</div>
      </div>
    </div>

    <div class="no-message-container" v-else>
      <i class="fa fa-comments-o"></i>
      <p>Seleccione un chat para leer mensajes.</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    contact: {
      type: Object
    },
    user: {
      type: Object,
    },
    messages: {
      type: Array,
      required: true
    }
  },
  methods: {
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop =
          this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
      }, 50);
    }
  },
  watch: {
    contact(contact) {
      this.scrollToBottom();
    },
    messages(messages) {
      this.scrollToBottom();
    }
  }
};
</script>