<script setup>
import {useForm} from "@inertiajs/vue3";
import LeafletMap from "@/Components/LeafletMap.vue";
import {computed, watch} from "vue";

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

//computed property for displaying latitude and longitude on the map.
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

//check for errors in the sensor fields.
watch(() => form.errors, () => {
    let alerted = false; //track if we already alerted the user.
    form.points.forEach((point, pointIndex) => {
        point.sensors.forEach((sensor, sensorIndex) => {
            if (alerted) return;
            //nested error objects get returned using point notation.
            if (!form.errors[`points.${pointIndex}.sensors.${sensorIndex}.type`] || !form.errors[`points.${pointIndex}.sensors.${sensorIndex}.unit`]) return;
            alert("Sensor type or field are not allowed to be empty!");
        });
    });
})
</script>

<template>
    <h1>Set-up Reef</h1>
    <form @submit.prevent="form.post('/reefs')" >
        <section>
            <!-- General information section of form -->
            <div class="subsection" id="general-information">
                <h2>General Information</h2>
                <div class="container">
                    <label for="name">Name:</label>
                    <input
                        v-model="form.name"
                        name="name"
                        type="text"
                        placeholder=" Rotterdam Blue City North"
                        required
                    />
                    <div class="error" v-if="form.errors.name" v-text="form.errors.name"></div>
                    <label for="datePlaced">Date of placement:</label>
                    <input
                        v-model="form.placedOn"
                        name="datePlaced"
                        type="date"
                        required
                    />
                    <div class="error" v-if="form.errors.placedOn" v-text="form.errors.placedOn"></div>
                    <label for="diagram">Upload diagram:</label>
                    <input type="file"
                           name="diagram"
                           @input="form.diagram = $event.target.files[0]"
                    >
                    <div class="error" v-if="form.errors.diagram" v-text="form.errors.diagram"></div>
                </div>
            </div>
            <div class="subsection" id="location">
                <h2>Location:</h2>
                <div class="error" v-if="form.errors.latitude || form.errors.longitude">Select a valid location on the map.</div>
                <LeafletMap :markers="currentPosition"
                            @on-map-clicked="setLatitudeLongitude"/>
            </div>
            <!-- point & sensor section of form !-->
            <div class="subsection" v-for="(point, pointIndex) in form.points" :key="pointIndex">
                <h2>Point {{pointIndex + 1}}</h2>
                <div class="container">
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
                                    placeholder="ex: humidity"
                                />
                            </td>
                            <td>
                                <input
                                    v-model="sensor.unit"
                                    type="text"
                                    placeholder="ex: %"
                                />
                            </td>
                            <td>
                                <button type="button" @click="removeSensor(pointIndex, sensorIndex)">Delete</button>
                            </td>
                        </tr>
                    </table>
                    <button type="button" @click="addSensor(pointIndex)">Add sensor</button>
                    <button type="button" @click="removePoint">Delete</button>
                </div>
            </div>
            <button type="button" @click="addPoint">Add Point</button>
            <button type="submit" :disabled="form.processing">Submit</button>
        </section>
    </form>
</template>

<style scoped>
    input {
        text-align: right;
    }
    .error {
        color: red;
    }
    .container {
        display: flex;
        flex-flow: column;
        width: min(100%, 50ch);
    }

    #general-information {
        .error {
            text-align: right;
        }
        label {
            margin-top: 0.5em;

            &:first-child {
                margin: 0;
            }
        }
    }

    table, th, td {
        border: 2px solid var(--dark-green);
    }
    table {
        width: 100%;
        border-collapse: collapse;

        input {
            box-sizing: border-box;
            width: 100%;
            border: none;
            font-size: 1.25em;

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
        align-self: flex-start;
    }
</style>
