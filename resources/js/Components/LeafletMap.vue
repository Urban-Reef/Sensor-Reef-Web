<script setup>
import 'leaflet/dist/leaflet.css';
import leaflet from 'leaflet';
import {onBeforeUpdate, onMounted} from "vue";

const emit = defineEmits(['onMapClicked']);
const props = defineProps(['markers']); //pas marker props as an array with objects containing lat and long.

let map;
let markers = [];

const loadMap = () => {
    //create map
    map = leaflet.map('map').setView([51.897839, 4.417300], 17);

    //get tile layer.
    leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //set an event listener to emit a custom event with original event object.
    map.on('click', (e) => {emit("onMapClicked", e)});

    loadMarkers();
}
const loadMarkers = () => {
    //check if markers prop is defined.
    if (!props.markers) return;

    props.markers.forEach((propMarker, index) => {
        //check if marker already exists in markers.
        if (index >= 0 && index < markers.length) {
            //if it exists update marker with new position.
            markers[index].setLatLng([propMarker.lat, propMarker.lng]);
            return;
        }
        //if not create marker using leaflet and push.
        const newMarker = leaflet.marker([propMarker.lat, propMarker.lng]).addTo(map);
        markers.push(newMarker);
    });
}

onMounted(loadMap);
onBeforeUpdate(loadMarkers); //run when component is updated.
</script>

<template>
<div id="map"></div>
</template>

<style scoped>
    #map {
        width: 100%;
        height: 360px;
    }
</style>
