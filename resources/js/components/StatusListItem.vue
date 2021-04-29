<template>
  <div class="card mb-3 border-0">
    <div class="card-body d-flex flex-column shadow-sm">
      <div class="d-flex align-items-center mb-3">
        <img
          class="rounded mr-3 shadow-sm"
          width="40px"
          src="https://aprendible.com/images/default-avatar.jpg"
          alt=""
        />
        <div class="">
          <h5 class="mb-1" v-text="status.user_name"></h5>
          <div class="small text-muted" v-text="status.ago"></div>
        </div>
      </div>
      <p class="card-text text-secondary" v-text="status.body"></p>
    </div>
    <div
      class="card-footer p-2 rounded shadow-sm d-flex justify-content-between align-items-center"
    >
      <like-btn :status="status"></like-btn>

      <div class="text-secondary mr-2">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">{{ status.likes_count }}</span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in comments" class="mb-3">
        <img class="rounded shadow-sm float-left mr-2" width="34px" :src="comment.user_avatar" :alt="comment.user_name">
          <div class="card border-0 shadow-sm">
              <div class="card-body p-2 text-secondary">
                <a href=""><strong>{{ comment.user_name }}</strong></a>
                {{ comment.body }}
              </div>
          </div>
      </div>
      <!-- agregamos el submit para que escuche el envio y prevent para que no se racargue la pagina -->
      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <!-- el v-model guarda lo que el usuario ingrese en el textarea -->
        <div class="d-flex align-items-center">
            <img class="rounded shadow-sm mr-2" width="34px" src="https://aprendible.com/images/default-avatar.jpg" :alt="currentUser.name">
            <!-- esta clase de bootstrap lo que hace es poner un una fila el input y boton pero este quedan sin border en la unuion -->
            <div class="input-group">
                <textarea v-model="newComment" class="form-control border-0 shadow-sm" placeholder="Escribe un comentario" name="comment" rows="1" ></textarea>
                <div class="input-group-append">
                    <button dusk="comment-btn" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
      </form>

    </div>
  </div>
</template>

<script>
import LikeBtn from "./LikeBtn";

export default {
  props: {
    //podemos indicar un objeto e indicar el tipo de dato
    //ademas indicamos que el tipo de dato sea obligatorio
    status: {
      type: Object,
      required: true,
    },
  },
  components: { LikeBtn },

  data() {
    return {
      newComment: "",
      comments: this.status.comments,
    };
  },
  methods: {
    addComment() {
      axios
        .post(`statuses/${this.status.id}/comments`, { body: this.newComment })
        .then((res) => {
          //hacemos un push del nuevo comentario
          this.newComment = "";
          this.comments.push(res.data.data);
        }).catch(err=>{
                console.log(err.response.data)
            });
    },
  },
};
</script>

