<template>
    <main-layout>
        <div class="mt-3">
            <div v-for="(group, index) in products" :key="index" class="mt-3">
                <div v-if="group.length > 0">
                    <h2 class="rounded-t-lg p-3 bg-green-400">{{ index }}</h2>
                    <div class="p-2 shadow-xl">
                        <div v-for="(product) in group" :key="product.id" class="flex gap-3">
                            <div
                                class="p-3 cursor-pointer bg-gray-300 transition-all duration-200 active:bg-green-800 active:text-white"
                                v-on:click="addProductToShoppingList(product.id)">
                                <p>{{ product.name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
import {BeakerIcon} from '@heroicons/vue/solid'

import MainLayout from '@/Layouts/MainLayout.vue'

export default {
    props: ['products', 'categories'],
    computed: {},
    components: {MainLayout, BeakerIcon},
    methods: {
        addProductToShoppingList(id) {
            this.$inertia.post(`/items/add/${id}`);

        }
    }
}
</script>
