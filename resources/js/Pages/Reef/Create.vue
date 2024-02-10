<script setup>
import {useForm} from "@inertiajs/vue3";
import 'leaflet/dist/leaflet.css';
import leaflet from 'leaflet';
import {onMounted} from "vue";

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

// TODO: Break map out into its own component.
let map;
let marker;

const loadMap = () => {
    //create map
    map = leaflet.map('map').setView([51.897839, 4.417300], 17);

    //get tile layer.
    leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //create marker used to track position.
    marker = leaflet.marker([51.897839, 4.417300]).addTo(map);

    map.on('click', setLatitudeLongitude);
}
const setLatitudeLongitude = (e) => {
    //Round latitude and longitude to 6th decimal.
    const lat = Number(e.latlng.lat.toFixed(6));
    const lng = Number(e.latlng.lng.toFixed(6));

    //set form lat and long.
    form.latitude = lat;
    form.longitude = lng;

    //set marker lat and lng.
    marker.setLatLng([lat, lng]);
}
onMounted(loadMap);

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
    <form @submit.prevent>
        <section>
            <!-- General information section of form -->
            <div class="subsection">
                <h2>General Information</h2>
                <label for="name">Name:
                    <input
                        v-model="form.name"
                        name="name"
                        type="text"
                        required
                    />
                </label>
                <label for="datePlaced">Date of placement:
                    <input
                        v-model="form.placedOn"
                        name="datePlaced"
                        type="date"
                        required
                    />
                </label>
                <label for="diagram">Upload diagram:
                    <input type="file"
                           name="diagram"
                           @input="form.diagram = $event.target.files[0]"
                    >
                </label>
            </div>
            <div class="subsection">
                <h2>Location:</h2>
                <div id="map"></div>
            </div>
            <!-- point & sensor section of form !-->
            <div class="subsection" v-for="(point, pointIndex) in form.points" :key="pointIndex">
                <h2>Point {{pointIndex + 1}}</h2>
                <div class="sensorTableRow"><strong>Type</strong><strong>Unit</strong></div>
                <div class="sensorTableRow" v-for="(sensor, sensorIndex) in point.sensors" :key="`${pointIndex}.${sensorIndex}`">
                    <input v-model="sensor.type" type="text"/>
                    <input v-model="sensor.unit" type="text"/>
                    <button @click="removeSensor(pointIndex, sensorIndex)">Delete</button>
                </div>
                <button @click="addSensor(pointIndex)">Add sensor</button>
                <button @click="removePoint">Delete</button>
            </div>
            <button @click="addPoint">Add Point</button>
            <button type="submit" @click="form.post('/reefs')">Submit</button>
        </section>
    </form>
</template>

<style scoped>
    #map {
        height: 360px;
    }
    .subsection {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    label {
        display: flex;
        justify-content: space-between;
    }

    .sensorTableRow {
        display: grid;
        grid-template-columns: 2fr 2fr 1fr;
        column-gap: 5px;

        input {
            box-sizing: border-box;
            width: 100%;
        }
    }
</style>
