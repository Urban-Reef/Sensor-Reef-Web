<script setup>
import {useForm} from "laravel-precognition-vue-inertia";
import EnvironmentSection from "@/Components/monitoring/EnvironmentSection.vue";
import PointSection from "@/Components/monitoring/PointSection.vue";
import Button from "@/Components/Button.vue";
import {provide} from "vue";

const props = defineProps(['reef']);
const form = useForm('post', route('reefs.session.store', props.reef.id), {
    points: props.reef.points.map(createFormPoint)
});

function createFormPoint(point) {
    return {
        id: point.id,
        photos: [],
        sample: "0",
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

provide('validation', {
    validate(name) {
        form.forgetError(name);
        form.validate(name);
    },
    invalid(name) {
        return form.invalid(name)
    },
    getError(name) {
        return form.errors[name]
    }
});

</script>

<template>
    <form novalidate @submit.prevent="form.submit()">
        <template v-for="(point, pointIndex) in form.points">
            <EnvironmentSection v-if="pointIndex === 0" :key="point.id" v-model="form.points[pointIndex]"/>
            <PointSection v-else :key="point.id" v-model:point="form.points[pointIndex]"
                          :point-index="pointIndex" :sensors="reef.points[pointIndex].sensors"/>
        </template>
        <Button :disabled="form.processing" theme="dark" type="submit">Save</Button>
    </form>
</template>
