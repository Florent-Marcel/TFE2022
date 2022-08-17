<script setup>
defineProps(['value']);
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ __(value) }}</span>
        <span v-else><slot /></span>
    </label>
</template>
