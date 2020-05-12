<template>
  <div class="chat">
    <div class="chat-header">
      <template v-if="contact && contact.estado==1">
        <div class="chat-header-user">
          <figure
            class="avatar avatar-lg"
            v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0"
          >
            <img
              src="/assets/images/colegio/school.png"
              class="rounded-circle"
              v-if="contact.colegio.c_logo==null"
            />
            <img
              :src="`/super/colegio/logo/${contact.colegio.c_logo}`"
              class="rounded-circle"
              v-else
            />
          </figure>
          <figure class="avatar avatar-lg" v-else-if="contact.id_docente!=null">
            <template v-if="contact.docente.c_foto==null">
              <img
                src="/assets/images/usuario/teacherman.png"
                class="rounded-circle"
                v-if="contact.docente.c_sexo=='M'"
              />
              <img src="/assets/images/usuario/teacherwoman.png" class="rounded-circle" v-else />
            </template>
            <img
              :src="`/super/docente/foto/${contact.docente.c_foto}`"
              class="rounded-circle"
              v-else
            />
          </figure>
          <figure class="avatar avatar-lg" v-else-if="contact.id_alumno!=null">
            <template v-if="contact.alumno.c_foto==null">
              <img
                src="/assets/images/usuario/studentman.png"
                class="rounded-circle"
                v-if="contact.alumno.c_sexo=='M'"
              />
              <img src="/assets/images/usuario/studentwoman.png" class="rounded-circle" v-else />
            </template>
            <img :src="`/super/alumno/foto/${contact.alumno.c_foto}`" class="rounded-circle" v-else />
          </figure>

          <div>
            <h5
              v-if="contact.id_docente==null && contact.id_alumno==null && contact.b_root==0"
            >{{contact.colegio.c_representante_legal}}</h5>
            <h5 v-if="contact.id_docente!=null">{{contact.docente.c_nombre}}</h5>
            <h5 v-if="contact.id_alumno!=null">{{contact.alumno.c_nombre}}</h5>
            <small class="text-muted">
              <i v-if="contact.is_online">Online</i>
              <i v-else>Offline</i>
            </small>
          </div>
        </div>
      </template>
      <div v-else-if="contact && contact.name" class="chat-header-user">
        <figure class="avatar avatar-lg">
          <span class="avatar-title bg-warning bg-success rounded-circle">
            <i class="fa fa-users"></i>
          </span>
        </figure>
        <div>
          <h5>{{contact.name}}</h5>
        </div>
      </div>
      <p v-else>Selecciona un usuario o grupo</p>
    </div>
    <MessagesFeed :contact="contact" :user="user" :messages="messages" />

    <MessageComposer @send="sendMessage" />
  </div>
</template>
<script>
import MessagesFeed from "./MessagesFeed";
import MessageComposer from "./MessageComposer";

export default {
  props: {
    user: {
      type: Object,
      default: null
    },
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
    sendMessage(text) {
      if (!this.contact) {
        return;
      }

      if (this.contact.estado == 1) {
        //envio a un usuario
        axios
          .post("/chat/conversation/send", {
            contact_id: this.contact.id,
            text: text
          })
          .then(response => {
            this.contact.ultimo_mensaje = text;
            this.$emit("new", response.data);
          });
      } else if (this.contact.name) {
        //envio a un grupo
        axios
          .post("/chat/group/sendmessage", {
            message: text,
            group_id: this.contact.id
          })
          .then(response => {
            this.$emit("new",response.data);
          });
      }
    }
  },
  components: { MessagesFeed, MessageComposer }
};
</script>