<script setup>
import ImageInput from "@/Components/ImageInput.vue";
import {inject} from "vue";
import Biodiversity from "@/Components/monitoring/BiodiversityEntry.vue";

//inject form for precognitive methods.
const validation = inject('validation');
const point = defineModel();

</script>
<template>
    <section>
        <h2>Environment</h2>
        <div class="subsection photos">
            <h2>Wide angle photos</h2>
            <ImageInput name="left"
                        v-model:image="point.photos[0]"
                        @upload="validation.validate('points.0.photos.0')"/>
            <p class="error" v-if="validation.invalid('points.0.photos.0')">
                {{ validation.getError('points.0.photos.0') }}
            </p>
            <ImageInput name="front"
                        v-model:image="point.photos[1]"
                        @upload="validation.validate('points.0.photos.1')"/>
            <p class="error" v-if="validation.invalid('points.0.photos.1')">
                {{ validation.getError('points.0.photos.1') }}
            </p>
            <ImageInput name="right"
                        v-model:image="point.photos[2]"
                        @upload="validation.validate(`points.0.photos.2`)"/>
            <p class="error" v-if="validation.invalid('points.0.photos.2')">
                {{ validation.getError('points.0.photos.2') }}
            </p>
        </div>
        <Biodiversity :point-index="0"/>
    </section>
</template>
<style scoped>
.photos {
    gap: var(--subsection-padding);

    .error {
        align-self: center;
        margin: 0;
    }
}
</style>
