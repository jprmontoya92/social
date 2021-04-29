<template>
<!-- por regla general podemos utilizar un elemento dentro de template de un componente  -->
    <button
        v-if="status.is_liked"
        dusk="unlike-btn"
        class="btn btn-link btn-small"
        @click="unlike(status)"
    >
        <strong>
        <i class="fa fa-thumbs-up text-primar mr-1"></i>
        TE GUSTA
        </strong>
    </button>
    <button
        v-else
        dusk="like-btn"
        class="btn btn-link btn-small"
        @click="like(status)"
    >
        <i class="far fa-thumbs-up text-primary mr-1"></i>
        ME GUSTA
    </button>
</template>

<script>
export default {
    props: {
        //podemos indicar un objeto e indicar el tipo de dato
        //ademas indicamos que el tipo de dato sea obligatorio
        status: {
            type: Object,
            required: true,
        },
    },
     methods: {

        like(status){
            axios.post(`statuses/${status.id}/likes`)
            .then(res => {
                status.is_liked = true;
                status.likes_count ++;
                
            });
        },

         unlike(status){
            axios.delete(`statuses/${status.id}/likes`)
            .then(res => {
                status.is_liked = false;
                status.likes_count --;
                
            });
        },
    },
};
</script>

<style>
</style>