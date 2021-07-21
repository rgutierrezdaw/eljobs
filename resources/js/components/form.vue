<template>
    <div class="form-content">
        <div>
            <h1 class="text-center title">{{title}}</h1>   
        </div>
        <div class="d-flex p-5 justify-content-center">
            <form class="bg-transparent d-flex flex-column justify-content-center" enctype="multipart/form-data" v-on:submit.prevent="sendImage()">
                <div class="p-4">
                    <input type="file" name="image">
                </div>    
                <div class="p-4">
                    <label>{{type}}</label>
                </div>
                <div class="d-flex justify-content-center">
                    <input class="btn button" type="submit" value="Enviar" accept="image/png, image/jpeg, image/GIF">
                </div>
            </form>
        </div> 
    </div>   
</template>

<script>
    export default {
         data() {
             return{
               title: "Insert your image",
               type: "Support JPEG, PNG and GIF images",
               image:""
             }  
        },
        methods: {
            sendImage(){
                alert(this.image)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>