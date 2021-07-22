<template>
    <div class="container flex justify-content-around">
        <div class="form-content">
            <h1 class="title text-center">Insert your image</h1>
            <div class="d-flex p-5 justify-content-center">
                <div class="bg-transparent d-flex flex-column justify-content-center">
                    <div class="p-4" v-if="image">
                        <img :src="image" class="img-responsive" height="70" width="90">
                    </div>
                    <div class="p-4">
                        <input type="file" v-on:change="onImageChange" class="form-control">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn button" @click="sendImage">Get color</button>
                    </div>
                </div>
            </div>       
        </div>
        <div class="result" v-if="!hidden">
            <h4>{{predominantColor}}</h4>
            <h4>{{nearestColor}}</h4>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                image: '',
                predominantColor: '',
                nearestColor: '',
                hidden: true
            }
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            sendImage(){
                axios.post('/upload',{image: this.image}).then(response => {
                   if (response.data) {
                     this.predominantColor="The predominant code color on image is: "+response.data[1]
                     this.nearestColor="The color closest to one of the palette is "+response.data[0]
                     this.hidden = false
                   }
                });
            }
        }
    }
</script>