<script setup>
import ImageInput from "@/Components/ImageInput.vue";
import {inject} from "vue";
import Biodiversity from "@/Components/monitoring/BiodiversityEntry.vue";

//TODO: Injecting and model binding? There has to be a better way.
//inject form for precognitive methods.
const validation = inject('validation');
const point = defineModel('point');
const props = defineProps({pointIndex: Number, sensors: Object});

</script>
<template>
    <section>
        <h2>Point {{ pointIndex }}</h2>
        <div class="subsection close-up">
            <h2>Close-Up</h2>
            <ImageInput :name="`close-up point ${pointIndex}`"
                        v-model:image="point.photos[0]"
                        @upload="validation.validate(`points.${pointIndex}.photos.0`)"
                        hide-label/>
            <p class="error" v-if="validation.invalid(`points.${pointIndex}.photos.0`)">
                {{ validation.getError(`points.${pointIndex}.photos.0`) }}</p>
        </div>
        <div class="subsection sample">
            <label :for="`samplePoint${pointIndex}`">Sample taken?</label>
            <input type="checkbox"
                   :id="`samplePoint${pointIndex}`"
                   v-model="point.sample"
                   true-value="1"
                   false-value="0"
                   @change="validation.validate(`points.${pointIndex}.sample`)"/>
            <p class="error" v-if="validation.invalid(`points.${pointIndex}.sample`)">
                {{ validation.getError(`points.${pointIndex}.sample`) }}</p>
        </div>
        <div class="subsection climate">
            <h2>Climate Data</h2>
            <div v-for="(formSensor, sensorIndex) in point.sensors" :key="`${point.id}.${sensorIndex}`">
                <label :for="`sensor${formSensor.id}`">{{ sensors[sensorIndex].type }}</label>
                <div class="climateInput">
                    <input type="number" step="0.1"
                           v-model="formSensor.value"
                           @change="validation.validate(`points.${pointIndex}.sensors.${sensorIndex}`)"/>
                    <span class="unit">{{ sensors[sensorIndex].unit}}</span>
                </div>
                <p class="error" v-if="validation.invalid(`points.${pointIndex}.sensors.${sensorIndex}`)">
                    {{ validation.getError(`points.${pointIndex}.sensors.${sensorIndex}`) }}</p>
            </div>
        </div>
        <Biodiversity :point-index="pointIndex"/>
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
        grid-column: 1 / 2;
        grid-row: 1 / 2;
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

        label {
            grid-column: 1 / 2;
            grid-row: 1 / 2;
            margin-right: 1em;
        }
        .climateInput {
            grid-column: 2 / 3;
            display: flex;
            flex-flow: nowrap;
            justify-content: end;
            align-items: center;
            max-width: 20ch;

            input {
                width: 100%;
                text-align: right;
            }
            .unit {
                text-align: right;
                margin-left: 1ch;
            }
        }

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
