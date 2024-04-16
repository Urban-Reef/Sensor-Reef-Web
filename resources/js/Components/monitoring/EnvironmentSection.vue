<script setup>
import ImageInput from "@/Components/ImageInput.vue";
import {inject} from "vue";

//inject form for precognitive methods.
const validation = inject('validation');
const point = defineModel();

</script>
<template>
    <section>
        <h2>Environment</h2>
        <div class="subsection">
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
            <!--        TODO: biodiversity monitoring component-->
        </div>
    </section>
</template>
<style scoped>
.error {
    align-self: center;
    margin: 0;
}
.subsection {
    gap: var(--subsection-padding);
}
</style>
