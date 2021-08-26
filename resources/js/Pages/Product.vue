<template>
    <main-layout>
        <div class="my-3">
            <form class="p-5 bg-gray-50 grid" @submit.prevent="submit">
                <label for="name">Produktname</label>
                <input class="border border-indigo-400 p-2" id="name" v-model="form.name" />
                <label class="mt-5" for="category">Kategorie:</label>
                <select id="category" v-model="form.category_id">
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                </select>
                <button class="rounded bg-gray-500 text-center text-white mt-5 p-4" type="submit">Submit</button>
            </form>
        </div>
    </main-layout>
</template>

<script>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import MainLayout from '@/Layouts/MainLayout.vue'

export default {
    props: ['categories'],
    components: {MainLayout},
    setup () {
        const form = reactive({
            name: null,
            category_id: 1,
        })

        function submit() {
            Inertia.post('/product', form)
        }

        return { form, submit }
    },
}
</script>
