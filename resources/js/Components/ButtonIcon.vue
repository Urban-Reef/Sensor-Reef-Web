<script setup>
defineProps({
    theme: {
        type: String,
        default: "light"
    },
    type: {
        type: String,
        default: "button"
    },
    opticalSize: {
        type: String,
        default: "48px"
    },
    icon: {
        type: String,
        required: true
    }
});
</script>

<template>
    <button :class="theme" :type="type">
        <span class="material-symbols-outlined">
            {{icon}}
        </span>
    </button>
</template>
<style scoped>

.material-symbols-outlined {
    font-size: v-bind(opticalSize);
    font-variation-settings: 'opsz' v-bind(opticalSize);
}

button {
    display: flex;
    justify-content: center;
    align-items: center;

    --btn-size: calc(v-bind(opticalSize) + 2rem);
    width: var(--btn-size);
    height: var(--btn-size);

    border: 4px solid;
    border-radius: 50%;
    outline: 3px solid;
    outline-offset: -8px;

    &:hover {
        cursor: pointer;
    }
}
.light {
    color: var(--dark-green);
    border-color: var(--white);
    outline-color: var(--dark-green);
    background: var(--white);

    &:hover {
        color: var(--white);
        border-color: var(--dark-green);
        outline-color: var(--white);
        background: var(--dark-green);
    }
}
.dark {
    color: var(--white);
    border-color: var(--dark-green);
    outline-color: var(--white);
    background: var(--dark-green);

    &:hover {
        border-color: var(--light-green);
        background: var(--light-green);
    }
}
</style>
