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
        <div class="subsection close-up">
            <h2>Close-Up</h2>
            <ImageInput :name="`close-up point ${pointIndex}`"
                        v-model="point.photos[0]"
                        @upload="form.validate(`points.${pointIndex}.photos.0`)"
                        hide-label/>
            <p class="error" v-show="form.invalid(`points.${pointIndex}.photos.0`)">
                {{ form.errors[`points.${pointIndex}.photos.0`] }}</p>
        </div>
        <div class="subsection sample">
            <label :for="`sample point ${pointIndex}`">Sample taken?</label>
            <input type="checkbox"
                   :id="`sample point ${pointIndex}`"
                   v-model="point.sample"
                   @change="form.validate(`points.${pointIndex}.sample`)"
            />
            <p class="error" v-if="form.invalid(`points.${pointIndex}.sample`)">
                {{ form.errors[`points.${pointIndex}.sample`] }}</p>
        </div>
        <div class="subsection climate">
            <h2>Climate Data</h2>
            <div v-for="(formSensor, sensorIndex) in point.sensors" :key="`${point.id}.${sensorIndex}`">
                <label :for="`sensor${formSensor.id}`">{{ sensors[sensorIndex].type }}</label>
                <input type="number" step="0.1"
                       v-model="formSensor.value"
                       @change="form.validate(`points.${pointIndex}.sensors.${sensorIndex}`)"
                />
                <p class="error" v-if="form.invalid(`points.${pointIndex}.sensors.${sensorIndex}`)">
                    {{ form.errors[`points.${pointIndex}.sensors.${sensorIndex}`] }}</p>
            </div>
        </div>
        <!--            TODO: Biodiversity monitoring component-->
    </section>
</template>
<style scoped>
.error {
    align-self: end;
}

.sample {
    display: grid;
    grid-template-columns: 1fr auto;
    grid-auto-rows: auto auto;

    label {
        font-size: 24px;
        font-weight: 700;
    }

    .error {
        text-align: right;
        grid-column: 1 / 3;
    }
}

.climate {
    gap: var(--subsection-padding);

    div {
        display: grid;
        grid-template-columns: 1fr auto;
        grid-auto-rows: auto auto;

        .error {
            text-align: right;
            grid-column: 1 / 3;
            padding-bottom: 0;
        }
    }
}

.close-up {
    .error {
        flex-grow: 1;
        align-self: center;
    }
}
</style>
