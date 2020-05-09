<template>
    <div class="chat-footer">
        <form action="">
            <input type="text" class="form-control" placeholder="Escribe algo"
                   aria-label="Recipient's username" aria-describedby="button-addon2" v-model="message" @keydown.enter="send">
            <div class="form-buttons">
                <button class="btn btn-light btn-floating" type="button">
                    <i class="fa fa-paperclip"></i>
                </button>
                <button class="btn btn-light btn-floating" type="button">
                    <i class="fa fa-microphone"></i>
                </button>
                <button class="btn btn-primary btn-floating" type="submit">
                    <i class="fa fa-send"></i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                message: ''
            };
        },
        methods: {
           send(e){
               e.preventDefault();
               if(this.message.length==0){
                   return; 
               }
               this.$emit('send',this.message);
               this.message = '';
           } 
        }
    }
</script>