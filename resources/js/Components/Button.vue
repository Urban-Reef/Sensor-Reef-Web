<script setup>
    const props = defineProps({
        theme: {
            type: String,
            default: "light"
        },
        type: {
            type: String,
            default: "button"
        }
    });
</script>
<template>
    <button :class="theme" :type="type">
        <slot />
    </button>
</template>
<style scoped>
button {
    padding: 1ch;
    border: 4px solid;
    border-radius: 10px;
    outline: 3px solid;
    outline-offset: -8px;
    font-size: 1.5rem;
    text-decoration: underline;

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
