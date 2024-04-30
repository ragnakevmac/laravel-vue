<template>
    <div>
        <h1>DJs</h1>
        <ul>
            <!-- Ensure you are iterating over the props correctly -->
            <li v-for="dj in djs" :key="dj.id">{{ dj.name }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        djs: Array,
    },
};
</script>
