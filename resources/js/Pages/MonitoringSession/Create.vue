<script setup>
import {useForm} from "@inertiajs/vue3";
import EnvironmentSection from "@/Components/monitoring/EnvironmentSection.vue";
import PointSection from "@/Components/monitoring/PointSection.vue";

const props = defineProps(['reef']);

const form = useForm({
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

</script>

<template>
<form @submit.prevent="form.post(route('reefs.session.store'))">
    <template v-for="(point, pointIndex) in form.points">
        <EnvironmentSection v-if="pointIndex === 0" v-model="form.points[pointIndex]" :key="point.id"/>
        <PointSection v-else v-model="form.points[pointIndex]" :point-index="pointIndex" :sensors="reef.points[pointIndex].sensors" :key="point.id"/>
    </template>
</form>
</template>
