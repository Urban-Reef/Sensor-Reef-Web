<script setup>
import ImageInput from "@/Components/ImageInput.vue";

const point = defineModel();
const props = defineProps({pointIndex: Object, sensors: Object});

</script>
<template>
<!--    TODO: Add validation messages-->
  <section>
    <h2>Point {{pointIndex}}</h2>
    <div class="subsection">
      <h2>Close-Up</h2>
      <ImageInput :name="`close-up point ${pointIndex}`" v-model="point.photos[0]" hide-label/>
    </div>
    <div class="subsection">
      <label :for="`sample point ${pointIndex}`">Sample taken?</label>
      <input type="checkbox" :id="`sample point ${pointIndex}`" v-model="point.sample">
    </div>
    <div class="subsection">
      <h2>Climate Data</h2>
      <div v-for="(formSensor, sensorIndex) in point.sensors" :key="`${point.id}.${sensorIndex}`">
        <label :for="`sensor${formSensor.id}`">{{sensors[sensorIndex].type}}</label>
        <input type="number" step="0.1" v-model="formSensor.value">
      </div>
    </div>
    <!--            TODO: Biodiversity monitoring component-->
  </section>
</template>
