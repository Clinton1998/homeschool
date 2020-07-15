<template>
  <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
      <div class="caja-comentarios">

              <h5 class="text-secondary" v-if="comments.length==0">Sin comentarios</h5>

              <div class="comentario mb-4" v-for="comment in comments">
                <strong class="comentario-persona" v-if="comment.comenta.id_docente==null">
                    <img  v-if="comment.comenta.alumno.c_foto==null && comment.comenta.alumno.c_sexo=='M'" class="rounded-circle" width="36" height="36" src="/assets/images/usuario/studentman.png" alt="Alumno">
                    <img  v-else-if="comment.comenta.alumno.c_foto==null && comment.comenta.alumno.c_sexo=='F'" class="rounded-circle" width="36" height="36" src="/assets/images/usuario/studentwoman.png" alt="Alumna">
                    <img v-else class="rounded-circle" width="36" height="36"  :src="`/super/alumno/foto/${comment.comenta.alumno.c_foto}`" alt="Foto del alumno">
                    <span class="hs_capitalize">{{comment.comenta.alumno.c_nombre}}</span>
                    ({{comment.created_at}})
                </strong>
                <strong class="comentario-persona" v-if="comment.comenta.id_docente">
                    <img  v-if="comment.comenta.docente.c_foto==null && comment.comenta.docente.c_sexo=='M'" class="rounded-circle" width="36" height="36" src="/assets/images/usuario/teacherman.png" alt="Docente">
                    <img  v-else-if="comment.comenta.docente.c_foto==null && comment.comenta.docente.c_sexo=='F'" class="rounded-circle" width="36" height="36" src="/assets/images/usuario/teacherwoman.png" alt="Docente">
                    <img v-else class="rounded-circle" width="36" height="36"  :src="`/super/docente/foto/${comment.comenta.docente.c_foto}`" alt="Foto del docente">
                    <span class="hs_capitalize">{{comment.comenta.docente.c_nombre}}</span>
                    ({{comment.created_at}})
                </strong>
                <p class="comentario-contenido">{{comment.c_descripcion}}</p>
              </div>

      </div>
  </div>
</template>
<script>
export default{
  props: {
    comments: {
      type: Array,
      required: true
    }
  }
};
</script>
