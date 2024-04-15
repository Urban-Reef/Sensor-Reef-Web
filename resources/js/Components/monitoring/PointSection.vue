<script setup>
import ImageInput from "@/Components/ImageInput.vue";
import {inject} from "vue";

//TODO: Injecting and modelling?!?
const form = inject('form');
const point = defineModel();
const props = defineProps({pointIndex: Number, sensors: Object});

</script>
<template>
    <!--    TODO: Add validation messages-->
    <section>
        <h2>Point {{ pointIndex }}</h2>
        <div class="subsection">
            <h2>Close-Up</h2>
            <ImageInput :name="`close-up point ${pointIndex}`" v-model="point.photos[0]" hide-label/>
            <p class="error">error message</p>
        </div>
        <div class="subsection">
            <label :for="`sample point ${pointIndex}`">Sample taken?</label>
            <input type="checkbox" :id="`sample point ${pointIndex}`" v-model="point.sample"/>
            <p class="error">error message</p>
        </div>
        <div class="subsection">
            <h2>Climate Data</h2>
            <div v-for="(formSensor, sensorIndex) in point.sensors" :key="`${point.id}.${sensorIndex}`">
                <label :for="`sensor${formSensor.id}`">{{ sensors[sensorIndex].type }}</label>
                <input type="number" step="0.1"
                       v-model="formSensor.value"
                       @change="form.validate(`points.${pointIndex}.sensors.${sensorIndex}`)"
                />
                <p class="error" v-show="form.invalid(`points.${pointIndex}.sensors.${sensorIndex}`)">{{ form.errors[`points.${pointIndex}.sensors.${sensorIndex}`] }}</p>
            </div>
        </div>
        <!--            TODO: Biodiversity monitoring component-->
    </section>
</template>
