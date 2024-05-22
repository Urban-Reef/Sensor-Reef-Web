<script setup>
import ImageInput from "@/Components/ImageInput.vue";
import Button from "@/Components/Button.vue";
import {useForm} from "laravel-precognition-vue-inertia";
import {inject} from "vue";

const props = defineProps(['pointIndex']);
const parentForm = inject('parentForm');

const biodiversityEntry = useForm('post', route('validate-biodiversity-entry'), {
    photo: null,
    count: null,
    species: ""
});
biodiversityEntry.validateFiles();

function validate(name) {
    biodiversityEntry.forgetError(name);
    biodiversityEntry.validate(name);
}

function addEntry() {
    biodiversityEntry.submit({
        onSuccess: () => {
            //push entry into form object.
            parentForm.addBiodiversityEntry(props.pointIndex, {
                photo: biodiversityEntry.photo,
                count: biodiversityEntry.count,
                species: biodiversityEntry.species
            });

            //reset form
            biodiversityEntry.reset();
        },
        preserveScroll: true
    });
}
</script>
<template>
    <div class="subsection">
        <h2>Biodiversity Monitoring</h2>
        <table>
            <tr>
                <th>Species</th>
                <th>Count</th>
            </tr>
            <tr v-for="entry in parentForm.getBiodiversityEntries(pointIndex)">
                <td>{{ entry.species }}</td>
                <td>{{ entry.count }}</td>
            </tr>
        </table>
        <ImageInput v-model:image="biodiversityEntry.photo"
                    :name="`Point${pointIndex}EntryPhoto`"
                    hide-label
                    @upload="validate('photo')"
        />
        <p v-if="biodiversityEntry.invalid('photo')" class="error photoError">{{ biodiversityEntry.errors.photo }}</p>
        <h3>Taxonomy</h3>
        <label :for="`Point${pointIndex}Count`">Count</label>
        <input :id="`PointPoint${pointIndex}Count`"
               v-model="biodiversityEntry.count"
               type="number"
               @change="validate('count')">
        <p v-if="biodiversityEntry.invalid('count')" class="error">{{ biodiversityEntry.errors.count }}</p>
        <label :for="`Point${pointIndex}Species`">Species</label>
        <input :id="`PointPoint${pointIndex}Species`"
               v-model="biodiversityEntry.species"
               type="text"
               @change="validate('species')">
        <p v-if="biodiversityEntry.invalid('species')" class="error">{{ biodiversityEntry.errors.species }}</p>
        <Button theme="dark" type="button" @click="addEntry">Add</Button>
    </div>
</template>

<style scoped>
.error {
    align-self: end;
    margin: 0;
}

.photoError {
    align-self: center;
}

h3 {
    margin-bottom: 0;
}

label {
    margin-top: var(--subsection-padding);
}

input {
    text-align: right;
}

button {
    margin-top: var(--subsection-padding);
}

table, th, td {
    border: 2px solid var(--dark-green);
    text-align: center;
}
th {
    background-color: var(--light-green);
    color: var(--white);
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
}
</style>
