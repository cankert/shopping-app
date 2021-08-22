<template>
    <div class="py-3 px-5 flex bg-gray-200 gap-2">
        <a :href="route('items')" class="bg-white shadow-md p-3">Items</a>
        <a :href="route('products')" class="bg-white shadow-md p-3">Products</a>
    </div>

    <!-- Page Content -->
    <main class="px-5">
        <slot></slot>
    </main>
</template>

<script>
export default {
    name: "MainLayout"
}
</script>

<style scoped>

</style>
