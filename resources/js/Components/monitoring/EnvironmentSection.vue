<script setup>
import ImageInput from "@/Components/ImageInput.vue";

const point = defineModel();

</script>
<template>
<!--    TODO: Validation Messages-->
  <section>
    <h2>Environment</h2>
    <div class="subsection">
      <h2>Wide angle photos</h2>
      <ImageInput name="left" v-model="point.photos[0]"/>
        <p class="error">error message</p>
      <ImageInput name="front" v-model="point.photos[1]"/>
        <p class="error">error message</p>
      <ImageInput name="right" v-model="point.photos[2]"/>
        <p class="error">error message</p>
      <!--        TODO: biodiversity monitoring component-->
    </div>
  </section>
</template>
