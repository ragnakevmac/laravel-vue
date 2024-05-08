<template>
    <div>
        <h1>Songs</h1>
        <ul>
            <!-- Ensure you are iterating over the props correctly -->
            <li v-for="song in songs" :key="song.id">{{ song.name }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        songs: Array,
    },
};
</script>
