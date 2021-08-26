<template>
    <main-layout>
        <div class="my-3">
            <Link class="mt-3 rounded bg-black text-white text-center" href="/product" method="get">
                <div class="rounded bg-black text-white text-center p-2">Neues Produkt</div>
            </Link>
            <div v-for="(group, index) in products" :key="index" class="mt-3">
                <div v-if="group.length > 0">
                    <h2 class="rounded-t-lg p-3 bg-green-400">{{ index }}</h2>
                    <div class="p-2 shadow-xl">
                        <div class="grid grid-cols-2 gap-3">
                            <div
                                v-for="(product) in group" :key="product.id"
                                class="p-3 text-center cursor-pointer border border-gray-300 transition-all duration-200 active:bg-green-800 active:text-white"
                                v-on:click="addProductToShoppingList(product.id)">
                                {{ product.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
import { BeakerIcon } from '@heroicons/vue/solid'
import { Link } from '@inertiajs/inertia-vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

export default {
    props: ['products', 'categories'],
    computed: {},
    components: {MainLayout, BeakerIcon, Link},
    methods: {
        addProductToShoppingList(id) {
            this.$inertia.post(`/items/add/${id}`, {}, {
                preserveScroll: true
            });

        }
    }
}
</script>
