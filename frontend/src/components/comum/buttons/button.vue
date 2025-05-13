<template>
    <div class="bg-blue-500 hover:bg-blue-600 py-1.5 px-4 flex items-center gap-2 cursor-pointer rounded-md">
        <slot name="icon" />
        <span class="font-semibold">{{ label }}</span>
    </div>
</template>

<script>
export default {
    name: 'Button',
    props: {
        label: {
            type: String,
            required: true,
        },
    },
};
</script>
