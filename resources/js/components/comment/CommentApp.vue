<template>
  <div class="comment-task">
    <strong>Escribe un comentario</strong>
    <CommentComposer @send="sendComment" />
    <br>
    <h4 class="">Comentarios recientes</h4>

    <CommentsFeed :comments="comments" />

  </div>
</template>
<script>
  import CommentsFeed from "./CommentsFeed";
  import CommentComposer from "./CommentComposer";
  export default{
    props: {
      task: {
        type: Object,
        required: true
      },
      user: {
        type: Object,
        required: true
      },
      comentar: {
        type: String
      }
    },
    data() {
      return {
        comments : []
      }
    },
    mounted(){
      this.comments = this.task.comentarios;
      //cuando hay nuevos mensajes personales
      Echo.private(`commentfortask.${window.Laravel.userId}`).listen(
          "NewCommentTask",
          e => {
            this.comments.unshift(e.comentario);
          }
      );
    },
    methods: {
      sendComment(text){
        if(!this.task){
          return;
        }


        if(this.user){
          if(this.user.id_docente==null){
            //alumno
            if(this.comentar=='pendiente'){
              axios
                .post("/alumno/tarea/comentarpendiente", {
                  id_tarea: this.task.id_tarea,
                  comentario: text
                })
                .then(response => {
                  if(response.data.correcto){
                    this.task.comentarios.unshift(response.data.comentario);
                  }
                });
            }else if(this.comentar=='enviado'){
              axios
                .post("/alumno/tarea/comentarenviado", {
                  id_tarea: this.task.id_tarea,
                  comentario: text
                })
                .then(response => {
                  if(response.data.correcto){
                    this.task.comentarios.unshift(response.data.comentario);
                  }
                });
            }else if(this.comentar=='vencido'){
              axios
                .post("/alumno/tarea/comentarvencido", {
                  id_tarea: this.task.id_tarea,
                  comentario: text
                })
                .then(response => {
                  if(response.data.correcto){
                    this.task.comentarios.unshift(response.data.comentario);
                  }
                });
            }
          }else{
            //docente
            axios
              .post("/docente/tarea/comentar", {
                id_tarea: this.task.id_tarea,
                comentario: text
              })
              .then(response => {
                if(response.data.correcto){
                  this.task.comentarios.unshift(response.data.comentario);
                }
              });
          }
        }else{
          console.log('No entra');
        }
      }
    },
    components: {CommentsFeed,CommentComposer}
  }
</script>
