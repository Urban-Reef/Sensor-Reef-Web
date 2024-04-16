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
function addBiodiversityEntry(pointIndex, entry) {
    form.points[pointIndex].entries.push(entry)
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
provide('addBiodiversityEntry', addBiodiversityEntry);

</script>

<template>
    <form novalidate @submit.prevent="form.submit()">
        <template v-for="(point, pointIndex) in form.points">
            <EnvironmentSection v-if="pointIndex === 0" :key="point.id" v-model="form.points[pointIndex]"/>
            <PointSection v-else :key="point.id" v-model:point="form.points[pointIndex]"
                          :point-index="pointIndex" :sensors="reef.points[pointIndex].sensors"/>
        </template>
        <section id="submit">
        <Button :disabled="form.processing" theme="dark" type="submit">Save</Button>
        </section>
    </form>
</template>
<style scoped>
#submit {
    width: min(
        /* Small screens: 100% - margin to align button to side */
        100% - var(--section-margin) * 2,
            /* Large screens: 75ch + padding * 4 to align button to side.*/
        75ch + (var(--section-padding)) * 4
    );
    margin-top: 0;
    padding: 0;
    background: none;

    button {
        align-self: end;
    }
}
</style>
