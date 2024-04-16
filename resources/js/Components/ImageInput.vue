<script setup>
import ButtonIcon from "@/Components/ButtonIcon.vue";
import {computed, defineEmits} from "vue";

const emit = defineEmits(['upload']);
const image = defineModel('image');
const props = defineProps({name: String, hideLabel: Boolean});
const imageURL = computed(() => {
    return URL.createObjectURL(image.value);
})
const takePhoto = () => {
    //TODO: Program logic to take a photo instead of uploading.
}
const handleUpload = (event) => {
    image.value = event.target.files[0];
    emit('upload');
}
</script>

<template>
    <div>
        <label v-show="!props.hideLabel" :for="name">{{name}}</label>
        <div v-show="!image" class="container">
            <ButtonIcon icon="upload" theme="dark" @click="$refs.uploadInput.click()"/>
            <ButtonIcon icon="photo_camera" theme="dark" @click="takePhoto" />
            <input ref="uploadInput" :id="name" :name="name" type="file" accept="image/jpeg, image/jpg, image/png" @change="handleUpload($event)"/>
        </div>
        <img v-if="image" :alt="name" :src="imageURL">
    </div>
</template>

<style scoped>
    .container, img {
        width: min(100%, 75ch / 2);
        margin: 0 auto;
        aspect-ratio: 3/4;
        border: 2px solid var(--dark-green);
    }
    .container {
        display: flex;
        flex-flow: column;
        justify-content: space-evenly;
        align-items: center;
    }
    img {
        display: block;
        object-fit: cover;
    }
    label {
        display: block;
        text-align: center;
        margin: 0 auto;
    }
    input {
        display: none;
    }
</style>
