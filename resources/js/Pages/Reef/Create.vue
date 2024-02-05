<script setup>
import {reactive} from "vue";
import {router, useForm} from "@inertiajs/vue3";

const form = useForm({
    name: '',
    placedOn: '',
    long: '',
    lat: '',
    points: [{
        sensors: [{
            type: '',
            unit: '',
        }]
    }]
});

const addPoint = () => {
    const newPoint = {
        //sensor object for readability.
        sensors: [{
            type: '',
            unit: '',
        }]
    };

    form.points.push(newPoint);
}
const removePoint = (index) => {
    form.points.splice(index, 1);
}

const addSensor = (pointIndex) => {
    form.points[pointIndex].sensors.push({
        type: '',
        unit: '',
    });
}
const removeSensor = (pointIndex, sensorIndex) => {
    //Find the right point using pointIndex, then delete the sensor using Splice.
    form.points[pointIndex].sensors.splice(sensorIndex, 1);
}

</script>

<template>
    <h1>Set-up Reef</h1>
    <section>
        <form @submit.prevent>
            <div class="subsection">
                <h2>General Information</h2>
                <label for="name">Name:</label>
                <input
                    v-model="form.name"
                    name="name"
                    type="text"
                />
                <label for="datePlaced">Date of placement:</label>
                <input
                    v-model="form.placedOn"
                    name="datePlaced"
                    type="date"
                />
<!--                TODO: integrate map -->
                <label for="long">Longitude:</label>
                <input
                    v-model="form.long"
                    name="long"
                    type="number"
                />
                <label for="lat">Latitude:</label>
                <input
                    v-model="form.lat"
                    name="lat"
                    type="number"
                />
<!--                TODO: Add points form-->
            </div>
            <div class="subsection" v-for="(point, pointIndex) in form.points" :key="pointIndex">
                <h2>Point {{pointIndex + 1}}</h2>
                <table v-show="point.sensors.length > 0">
                    <tr>
                        <th>Type:</th>
                        <th>Unit:</th>
                        <th></th>
                    </tr>
                    <tr v-for="(sensor, sensorIndex) in point.sensors" :key="`${pointIndex}.${sensorIndex}`">
                        <td>
                            <input
                                v-model="sensor.type"
                                type="text"
                            />
                        </td>
                        <td>
                            <input
                                v-model="sensor.unit"
                                type="text"
                            />
                        </td>
                        <td>
                            <button @click="removeSensor(pointIndex, sensorIndex)">Delete</button>
                        </td>
                    </tr>
                </table>
                <button @click="addSensor(pointIndex)">Add sensor</button>
                <button @click="removePoint">Delete</button>
            </div>
            <button @click="addPoint">Add Point</button>

        </form>
    </section>
</template>

<style scoped>

</style>
