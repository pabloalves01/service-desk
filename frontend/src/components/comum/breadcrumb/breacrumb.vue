<template>
    <div class="flex justify-between items-center">
        <Breadcrumb :home="home" :model="items">
            <template #item="{ item, props }">
                <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                    <a :href="href" v-bind="props.action" @click="navigate">
                        <span :class="[item.icon, 'text-color']"></span>
                        <span class="text-primary text-sm font-semibold">{{ item.label }}</span>
                    </a>
                </router-link>
                <a v-else :href="item.url" :target="item.target" v-bind="props.action">
                    <span class="text-surface-700 dark:text-surface-0">{{ item.label }}</span>
                </a>
            </template>
        </Breadcrumb>

        <!-- Slot para os botões -->
        <div class="flex gap-2">
            <slot name="buttons"></slot>
        </div>
    </div>
</template>

<script>
import Breadcrumb from 'primevue/breadcrumb';

export default {
    name: 'AppBreadcrumb',
    components: { Breadcrumb },
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            home: {
                icon: 'pi pi-home',
                route: '/'
            }
        };
    }
};
</script>

<style scoped>
.p-breadcrumb {
    background-color: transparent !important;
    border: none !important;
    box-shadow: none !important;
}

.p-breadcrumb,
.p-breadcrumb>nav {
    padding: 0 !important;
}
</style>
