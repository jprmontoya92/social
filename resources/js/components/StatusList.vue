<template>
    <!-- esto hara que si surgen un evento click en los elemento hijos preguntara si el usuario estara autenticado, en caso de ser invitado sera redireccionado al login  -->
        <div @click="redirectIfGuest">
                
             <status-list-item 
                v-for="status in statuses"
                :status="status"
                :key="status.id"
            >

            </status-list-item> 
    </div>
</template>

<script>

//como recibimos un objeto status vamos a recibirolo como propiedad y le indicaremos que es un un objeto. Esta es una forma de validar la propiedades que recibimos en un componente vuejs
// de esta manera nos de error si es que no le pasamos un objeto 

import StatusListItem from './StatusListItem';

//ahora dentro de la instancia de vue,, debemos registrar este componente dentro de components
export default {
    components: {StatusListItem},
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
        
    },

    
}
</script>