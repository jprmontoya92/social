
//obtenemos el meta con el nombre user
let user = document.head.querySelector('meta[name="user"]');

module.exports = {

 //propiedad calculada
 computed: {
    //atraves del metodo user podremos acceder al objeto user
    currentUser(){
        return JSON.parse(user.content);
    },

    isAuthenticated(){
        //aqui podemos retornar si existe el contenido del usuario y la convertimos en bool !!
        return !! user.content
    },
    //otra verificacion es si es un invitado
    guest(){
        //lo opuesto a isAuthenticated
        return ! this.isAuthenticated
    }
  },
}