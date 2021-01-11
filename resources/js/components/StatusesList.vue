<template>
    <div>
         <div class="card mb-3 border-0" v-for="status in statuses">
             <div class="card-body d-flex flex-column shadow-sm">
                 <div class="d-flex align-items-center mb-3">
                    <img class="rounded mr-3 shadow-sm" width="40px" src="https://aprendible.com/images/default-avatar.jpg" alt="">
                    <div class="">
                        <h5 class="mb-1" v-text="status.user_name"></h5>
                        <div class="small text-muted" v-text="status.ago"></div>
                    </div>
                 </div>
                 <p class="card-text text-secondary" v-text="status.body"></p>
             </div>
         </div>
    </div>
</template>

<script>
export default {
    data(){
        return{

            statuses: []
        
        }
    },
    mounted(){
        axios.get('/statuses').then(res => {
             this.statuses  = res.data.data 
        }).catch(err =>{
            console.log(err);
        });
    //escucharemos los eventos de StatusForm, como primer parametro indicamos el evento que qeuremos escuchar y como segundo parametro le pasamos una funcion para cuando el evento ocurra y en este caso recibimos el estado como parametro
        EventBus.$on('status-created', status => {
            //entonces aqui agregamos al array de estados los estados
            //this.statuses.push(status);
            //para que lo agregue al principio y no al ultimo utilizamos 
            this.statuses.unshift(status)
        })
        
    }
}
</script>