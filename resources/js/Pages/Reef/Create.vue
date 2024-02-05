<script setup>
import {reactive} from "vue";
import {router, useForm} from "@inertiajs/vue3";

const form = useForm({
    name: '',
    placedOn: '',
    long: '',
    lat: ''
});

const handleSubmit = () => {
    form.post('/reefs');
}

</script>

<template>
    <h1>Set-up Reef</h1>
    <section>
        <div>
            <h2>General Information</h2>
            <form @submit.prevent="form.post('/reefs')">
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
                <button type="submit" :disabled="form.processing">Submit</button>
            </form>
        </div>
    </section>
</template>

<style scoped>

</style>
