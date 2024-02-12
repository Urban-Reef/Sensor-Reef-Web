<script setup>
import {useForm} from "@inertiajs/vue3";
import LeafletMap from "@/Components/LeafletMap.vue";
import {computed} from "vue";

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

const currentPosition = computed(() => {
    if (!form.latitude || !form.longitude) return null;
    return [{lat: form.latitude, lng: form.longitude}];
});
const setLatitudeLongitude = (e) => {
    //Round latitude and longitude to 6th decimal.
    const lat = Number(e.latlng.lat.toFixed(6));
    const lng = Number(e.latlng.lng.toFixed(6));

    //set form lat and long.
    form.latitude = lat;
    form.longitude = lng;
}

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
                <LeafletMap :markers="currentPosition"
                            @on-map-clicked="setLatitudeLongitude"/>
            </div>
            <!-- point & sensor section of form !-->
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
                <button @click.prevent="addSensor(pointIndex)">Add sensor</button>
                <button @click.prevent="removePoint">Delete</button>
            </div>
            <button @click.prevent="addPoint">Add Point</button>
            <button type="submit" @click="form.post('/reefs')">Submit</button>
        </section>
    </form>
</template>

<style scoped>
    label {
        display: flex;
        justify-content: space-between;
        width: min(100%, 500px);
    }

    table, th, td {
        border: 2px solid var(--dark-green);
    }
    table {
        width: min(100%, 500px);
        border-collapse: collapse;

        input {
            box-sizing: border-box;
            width: 100%;
            border: none;

            font-size: 1.25em;
            text-align: right;

            &:focus {
                outline: none;
            }
        }
    }
    th {
        background-color: var(--light-green);
        color: var(--white);
        text-align: left;
    }

    button {
        align-self: start;
    }
</style>
