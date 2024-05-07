<template>
    <div>
        <h1>Artists</h1>
        <ul>
            <!-- Ensure you are iterating over the props correctly -->
            <li v-for="artist in artists" :key="artist.id">
                {{ artist.name }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        artists: Array,
    },
};
</script>
