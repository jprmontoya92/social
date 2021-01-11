<template>
  <div>
      <form @submit.prevent="submit" v-if="isAuthenticated">
        <div class="card-body">
          <textarea
            v-model="body"
            class="form-control border-0 bg-light"
            name="body"
            :placeholder="`¿En que estas pensando ${currentUser.name}?`"
          ></textarea>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary" id="create-status">Publicar</button>
        </div>
      </form>
      <div class="card-body" v-else="isAuthenticated">
         <a href="/login">Debes hacer  Login</a>
      </div>
    </div>
</template>

<script>


export default {
    data(){
        return{
            body:'',

        }
    },
    methods:{
        submit(){
            axios.post('/statuses', {body: this.body}).then(res => {
              //en vez de agregar los datos a un array lo pasaremos por un bus de eventos esto para que los componentes se comuniquen entre si
            //this.statuses.push(res.data
            //como primer parametro recibe el nombre del evento y como segundo parametro , le podemos pasar cualquier informacion relevante, en este caso le pasaramos los estados
               EventBus.$emit('status-created', res.data.data);
               this.body = '';
            }).then(err=>{
                //console.log(err.response.data)
            });
        }
    }
};
</script>