<script setup>
import {useForm} from "@inertiajs/vue3";
import 'leaflet/dist/leaflet.css';
import leaflet from 'leaflet';
import {onMounted} from "vue";

onMounted(() => {
    const map = leaflet.map('map').setView([51.897839, 4.417300], 17);
    leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    map.on('click', (e) => {console.log(e)});
});

const form = useForm({
    name: '',
    placedOn: '',
    longitude: null,
    latitude: null,
    diagram: null,
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
    //Find the right point using pointIndex, then delete the sensor using splice.
    form.points[pointIndex].sensors.splice(sensorIndex, 1);
}

</script>

<template>
    <h1>Set-up Reef</h1>
    <section>
        <form @submit.prevent>
            <!-- General information section of form -->
            <div class="subsection">
                <h2>General Information</h2>
                <label for="name">Name:</label>
                <input
                    v-model="form.name"
                    name="name"
                    type="text"
                    required
                />
                <label for="datePlaced">Date of placement:</label>
                <input
                    v-model="form.placedOn"
                    name="datePlaced"
                    type="date"
                    required
                />
                <!-- TODO: integrate map -->
                <label for="long">Longitude:</label>
                <input
                    v-model="form.longitude"
                    name="long"
                    type="number"
                    step="any"
                    required
                />
                <label for="lat">Latitude:</label>
                <input
                    v-model="form.latitude"
                    name="lat"
                    type="number"
                    step="any"
                    required
                />
                <label for="diagram">Upload diagram:</label>
                <input type="file"
                       name="diagram"
                       @input="form.diagram = $event.target.files[0]"
                >
            </div>
            <div id="map"></div>
            <!-- point & sensor section of form !-->
            <div v-for="(point, pointIndex) in form.points" :key="pointIndex">
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
            <button type="submit" @click="form.post('/reefs')">Submit</button>
        </form>
    </section>
</template>

<style scoped>
#map {
    height: 360px;
}
</style>
