<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                Items Not Done
                <ol>
                    <li v-for="(item, index) in itemsNotDone" :key="item.id">
                    {{ item.name }}
                    {{ item.type }}
                    {{ item.done }}
                    <input type="checkbox" :checked="getDoneStatus(item.done)" v-on:click="checkItem(item.id, item.done)">
                    </li>    
                </ol>
                
                Items Done
                <li v-for="(item, index) in itemsDone" :key="item.id">
                {{ item.name }}
                {{ item.type }}
                {{ item.done }}
                <input type="checkbox" :checked="getDoneStatus(item.done)" v-on:click="checkItem(item.id, item.done)">
                </li>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['itemsNotDone', 'itemsDone'],
        components: {
        },
        methods: {
            checkItem(id, done) {
            this.$inertia.patch(`/items/${id}/update`, {
                'done': !!parseInt(done) ? false : true
            }
            )
            },
            getDoneStatus(status) {
                return !!parseInt(status);
            }
        }
    }
</script>
