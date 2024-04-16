<script setup>
import ImageInput from "@/Components/ImageInput.vue";
import Button from "@/Components/Button.vue";
import {useForm} from "laravel-precognition-vue-inertia";
import {inject} from "vue";

const props = defineProps(['pointIndex']);
const addBiodiversityEntry = inject('addBiodiversityEntry');

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
            addBiodiversityEntry(props.pointIndex, {
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
<!--        TODO: Display added entries -->
        <h2>Biodiversity Monitoring</h2>
        <ImageInput v-model:image="biodiversityEntry.photo"
                    :name="`Point${pointIndex}EntryPhoto`"
                    @upload="validate('photo')"
                    hide-label
        />
        <p class="error photoError" v-if="biodiversityEntry.invalid('photo')">{{ biodiversityEntry.errors.photo }}</p>
        <h3>Taxonomy</h3>
        <label :for="`Point${pointIndex}Count`">Count</label>
        <input :id="`PointPoint${pointIndex}Count`"
               v-model="biodiversityEntry.count"
               @change="validate('count')"
               type="number">
        <p class="error" v-if="biodiversityEntry.invalid('count')">{{ biodiversityEntry.errors.count }}</p>
        <label :for="`Point${pointIndex}Species`">Species</label>
        <input :id="`PointPoint${pointIndex}Species`"
               v-model="biodiversityEntry.species"
               @change="validate('species')"
               type="text">
        <p class="error" v-if="biodiversityEntry.invalid('species')">{{ biodiversityEntry.errors.species }}</p>
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
</style>
