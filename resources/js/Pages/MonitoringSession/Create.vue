<script setup>
import {useForm} from "@inertiajs/vue3";
import {onBeforeMount, onMounted} from "vue";

const props = defineProps(['reef']);

const form = useForm({
    points: props.reef.points.map(createFormPoint)
});
// onMounted(() => {
//     console.log(form.points);
// })

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
<!--    TODO: Dynamically create sections.-->
    <section>
        <h2>Environment</h2>
    </section>
    <section v-for="(point, index) in form.points">
        <h2>Point {{index}}</h2>
    </section>
</form>
</template>

<style scoped>

</style>
