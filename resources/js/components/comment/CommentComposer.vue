<template>
    <form>
        <input class="form-control form-control-lg mb-6" v-model="comment" @keydown.enter="send" rows="2" placeholder="Escribe aquí..." required autofocus>
        <div class="mb-4">
            <br>
            <button type="button" class="btn btn-primary float-right" @click="send">Publicar comentario</button>
        </div>
    </form>
</template>
<script>

  export default{
    data(){
      return {
        comment: ''
      }
    },
    methods: {
      send(e){
        e.preventDefault();
        if(this.comment.trim().length==0){
          return;
        }
        this.$emit('send',this.comment);
        this.comment = '';
      }
    }
  }

</script>
