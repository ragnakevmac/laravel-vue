<template>
    <div>
        <h1>Users</h1>
        <ul>
            <!-- Ensure you are iterating over the props correctly -->
            <li v-for="user in users" :key="user.id">{{ user.username }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        users: Array,
    },
};
</script>
