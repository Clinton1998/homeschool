<template>
  <div class="content">
    <ContactsList
      :contacts="contacts"
      :friends="friends"
      :groups="groups"
      @selected="startConversationWith"
    />
    <Conversation
      :contact="selectedContact"
      :user="user"
      :messages="messages"
      @new="saveNewMessage"
    />

    <div class="sidebar-group">
      <div id="contact-information" class="sidebar">
        <header>
          <span>About</span>
          <ul class="list-inline">
            <li class="list-inline-item">
              <a href="#" class="btn btn-light sidebar-close">
                <i class="ti-close"></i>
              </a>
            </li>
          </ul>
        </header>
        <div class="sidebar-body">
          <div class="pl-4 pr-4 text-center">
            <figure class="avatar avatar-state-danger avatar-xl mb-4">
              <img src="https://via.placeholder.com/150" class="rounded-circle" />
            </figure>
            <h5 class="text-primary">Frans Hanscombe</h5>
            <p class="text-muted">Last seen: Today</p>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <h6>About</h6>
            <p
              class="text-muted"
            >I love reading, traveling and discovering new things. You need to be happy in life.</p>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <h6>Phone</h6>
            <p class="text-muted">(555) 555 55 55</p>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <h6>Media</h6>
            <div class="files">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <a href="#">
                    <figure class="avatar avatar-lg">
                      <span class="avatar-title bg-warning">
                        <i class="fa fa-file-pdf-o"></i>
                      </span>
                    </figure>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <figure class="avatar avatar-lg">
                      <img src="https://via.placeholder.com/150" />
                    </figure>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <figure class="avatar avatar-lg">
                      <img src="https://via.placeholder.com/150" />
                    </figure>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <figure class="avatar avatar-lg">
                      <img src="https://via.placeholder.com/150" />
                    </figure>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <figure class="avatar avatar-lg">
                      <span class="avatar-title bg-success">
                        <i class="fa fa-file-excel-o"></i>
                      </span>
                    </figure>
                  </a>
                </li>
                <li class="list-inline-item">
                  <a href="#">
                    <figure class="avatar avatar-lg">
                      <span class="avatar-title bg-info">
                        <i class="fa fa-file-text-o"></i>
                      </span>
                    </figure>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <h6>City</h6>
            <p class="text-muted">Germany / Berlin</p>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <h6>Website</h6>
            <p>
              <a href="#">www.franshanscombe.com</a>
            </p>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <h6>Social Links</h6>
            <ul class="list-inline social-links">
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-facebook">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-twitter">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-dribbble">
                  <i class="fa fa-dribbble"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-whatsapp">
                  <i class="fa fa-whatsapp"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-linkedin">
                  <i class="fa fa-linkedin"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-google">
                  <i class="fa fa-google"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-behance">
                  <i class="fa fa-behance"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-sm btn-floating btn-instagram">
                  <i class="fa fa-instagram"></i>
                </a>
              </li>
            </ul>
          </div>
          <hr />
          <div class="pl-4 pr-4">
            <div class="form-group">
              <div class="form-item custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch11" />
                <label class="custom-control-label" for="customSwitch11">Block</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-item custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" checked id="customSwitch12" />
                <label class="custom-control-label" for="customSwitch12">Mute</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-item custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch13" />
                <label class="custom-control-label" for="customSwitch13">Get notification</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Conversation from "./Conversation";
import ContactsList from "./ContactsList";
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: [],
      friends: [],
      groups: []
    };
  },
  mounted() {
    //cuando hay nuevos mensajes personales
    Echo.private(`messages.${this.user.id}`).listen("NewMessage", e => {
      e.message.from_contact.ultimo_mensaje = e.message.text;
      this.hanleIncoming(e.message);
    });

    //cuando hay nuevos mensajes para grupos
    Echo.private(`messagesforgroup.${this.user.id}`).listen(
      "NewMessageForGroup",
      e => {
        this.hanleIncoming(e.conversation);
      }
    );

    //cuando hay nuevos grupos
    Echo.private(`groupusers.${this.user.id}`).listen("GroupCreated", e => {
      this.groups.push(e.group);
    });

    //cuando se eliminan grupos
    Echo.private(`groupusersdelete.${this.user.id}`).listen(
      "GroupDeleted",
      e => {
        //this.groups.push(e.group);
        var id_group = e.users[0]["pivot"]["group_id"];
        if (id_group) {
          //eliminamos el grupo
          for (var i = 0; i < this.groups.length; i++) {
            if (this.groups[i].id == id_group) {
              this.groups.splice(i, 1);
            }
          }
          if (
            this.selectedContact &&
            this.selectedContact.id == id_group &&
            this.selectedContact.users
          ) {
            this.selectedContact = null;
          }
        }
      }
    );

    axios.get("/chat/contacts").then(response => {
      this.contacts = response.data.contacts;
      this.friends = response.data.friends;
      this.groups = response.data.groups;
    });
  },
  methods: {
    startConversationWith(contact, tipo) {
      //el parametro contacto pueder ser un usuario o un grupo
      if (tipo == "contact") {
        this.updateUnreadCount(contact, true, tipo);
        axios.get(`/chat/conversation/${contact.id}`).then(response => {
          this.messages = response.data;
          if (response.data.length > 0) {
            contact.ultimo_mensaje =
              response.data[response.data.length - 1].text;
          } else {
            contact.ultimo_mensaje = "";
          }
          this.selectedContact = contact;
        });
      } else if (tipo == "group") {
        this.updateUnreadCount(contact.id, true, tipo);
        axios.get(`/chat/group/conversations/${contact.id}`).then(response => {
          this.messages = response.data.conversations;
          contact.users = response.data.users;
          this.selectedContact = contact;
        });
      }
    },
    saveNewMessage(message) {
      this.messages.push(message);
    },
    hanleIncoming(message) {
      if (this.selectedContact && message.group_id == this.selectedContact.id) {
        //mensaje para un grupo

        this.saveNewMessage(message);
        return;
      } else if (
        this.selectedContact &&
        message.emisor == this.selectedContact.id
      ) {
        //mensaje a una persona
        this.selectedContact.ultimo_mensaje = message.text;
        this.saveNewMessage(message);
        return;
      }
      var opcion = "";
      if (message.group_id) {
        opcion = "group";
      } else {
        opcion = "contact";
      }
      if (opcion == "contact") {
        this.updateUnreadCount(message.from_contact, false, opcion);
      } else {
        this.updateUnreadCount(message.group_id, false, opcion);
      }
    },
    updateUnreadCount(contact, reset, opt) {
      if (opt == "contact") {
        this.contacts = this.contacts.map(single => {
          if (single.id != contact.id) {
            return single;
          }
          if (reset) {
            single.unread = 0;
          } else {
            single.ultimo_mensaje = contact.ultimo_mensaje;
            single.unread += 1;
          }
          return single;
        });

        //para los friends
        if (!reset) {
          var ahora_contact = "";
          this.friends = this.friends.map(single => {
            if (single.id != contact.id) {
              return single;
            }
            single.ultimo_mensaje = contact.ultimo_mensaje;
            if (!single.unread) {
              single.unread = 1;
            }else{
              single.unread += 1;
            }
            ahora_contact = single;
            return single;
          });

          if(ahora_contact!=''){
            this.contacts.push(ahora_contact);
            for (var i = 0; i < this.friends.length; i++) {
              if (this.friends[i].id == ahora_contact.id) {
                  this.friends.splice(i, 1);
              }
            }
          }
        }
      } else {
        this.groups = this.groups.map(single => {
          if (single.id != contact) {
            return single;
          }
          if (reset) {
            single.unread = 0;
          } else {
            if (!single.unread) {
              single.unread = 1;
            } else {
              single.unread += 1;
            }
          }
          return single;
        });
      }
    }
  },
  components: { Conversation, ContactsList }
};
</script>