<template>
    <main-layout>
        <div class="my-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="(group,index) in itemsNotDone" :key="index" class="mt-3 shadow-xl rounded-lg">
                    <h2 class="rounded-t-lg p-3 bg-green-400">{{index}}</h2>
                    <div v-for="(item) in group" :key="item.id">
                        <div class="p-3 flex gap-4">
                            <div class="rounded w-1/4  bg-gray-800 text-white items-center text-center flex justify-center">
                                <div v-on:click="minusOne(item.id)" class="w-1/3 p-2 bg-gray-700 active:bg-red-400">-</div>
                                <div class="w-1/3 p-2">{{ item.quantity }}</div>
                                <div v-on:click="plusOne(item.id)" class="w-1/3 p-2 bg-gray-700 active:bg-green-400">+</div>
                            </div>
                            <div class="p-3 w-2/4">
                                {{ item.product.name }}
                            </div>
                            <div class="rounded p-3 text-right shadow-md" v-on:click="checkItem(item.id, item.done)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="itemsDone.length > 0" class="shadow-xl rounded-lg mt-5">
                    <h2 class="rounded-t-lg p-3 bg-gray-400 text-white">Done</h2>
                    <div v-for="(item) in itemsDone" :key="item.id" class="p-3 flex gap-3">
                        <div class="w-1/4 rounded p-3 bg-gray-400 text-white text-center">
                            {{ item.quantity }}
                        </div>
                        <div class="w-2/4 p-3 text-center">
                            {{ item.product.name }}
                        </div>
                        <div class="w-1/4 p-3 text-center bg-gray-400 text-white" v-on:click="checkItem(item.id, item.done)">
                            <button class="">Zurück</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
import MainLayout from '@/Layouts/MainLayout.vue'

export default {
    props: ['itemsNotDone', 'itemsDone', 'categories'],
    components: {MainLayout},
    computed: {},
    methods: {
        checkItem(id, done) {
            this.$inertia.patch(`/items/${id}/update`, {
                    'done': !parseInt(done)
                },
                {
                    preserveScroll: true
                }
            )
        },
        plusOne(id) {
            this.$inertia.post(`/items/plus/${id}`, {}, {
                preserveScroll: true
            });
        },
        minusOne(id) {
            this.$inertia.post(`/items/minus/${id}`,{}, {
                preserveScroll: true
            });
        },
        getDoneStatus(status) {
            return !!parseInt(status);
        }
    }
}
</script>
