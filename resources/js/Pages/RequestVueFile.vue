<template>
    <div>
        <h1>USERNAME - SONG NAME</h1>
        <ul>
            <!-- Ensure you are iterating over the props correctly -->
            <li v-for="request in requests" :key="request.id">
                {{ request.users.username }} -
                {{ request.artist_song.songs.name }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        requests: Array,
    },
};
</script>
