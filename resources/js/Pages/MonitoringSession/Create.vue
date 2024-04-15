<script setup>
import {useForm} from "laravel-precognition-vue-inertia";
import EnvironmentSection from "@/Components/monitoring/EnvironmentSection.vue";
import PointSection from "@/Components/monitoring/PointSection.vue";
import Button from "@/Components/Button.vue";
import {provide} from "vue";

const props = defineProps(['reef']);
const form = useForm('post', route('reefs.session.store', props.reef.id),{
    points: props.reef.points.map(createFormPoint)
});
function createFormPoint(point) {
    return {
        id: point.id,
        photos: [],
        sample: false,
        sensors: point.sensors.map((sensor) => {
            return {
                id: sensor.id,
                value: null
            }
        }),
        entries: [],
    }
}
form.validateFiles();
provide('form', form);

</script>

<template>
<form @submit.prevent="form.submit()" novalidate>
    <template v-for="(point, pointIndex) in form.points">
        <EnvironmentSection v-if="pointIndex === 0" v-model="form.points[pointIndex]" :key="point.id"/>
        <PointSection v-else v-model="form.points[pointIndex]" :point-index="pointIndex" :sensors="reef.points[pointIndex].sensors" :key="point.id"/>
    </template>
    <Button :disabled="form.processing" theme="dark" type="submit">Save</Button>
</form>
</template>
