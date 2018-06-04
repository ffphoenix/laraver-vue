<template>
    <div v-if="isLodading" class="preloader">
        <pulse-loader :loading="isLodading" color="#4dbd74"></pulse-loader>
    </div>
</template>

<script>
    import PulseLoader from 'vue-spinner/src/PacmanLoader.vue';
    export default {
        props: ['isLodading'],
        components : {
            PulseLoader
        }
    }
</script>
<style>
    .preloader {
        width: 100%;
        height: 100%;
        margin-top: 0;
        position: absolute;
        z-index: 999;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        padding: 30px;
        padding-top: 100px;
    }
    .card form, .card table.table {
        position: relative;
    }
    .card table.table.table-loading {
        min-height: 200px;
        border: none;
    }
    .card table.table .preloader{
        margin-top: -32px;
    }
</style>
