<template>
    <div>
        <form @submit.prevent="submit">
            <textarea
                v-model="form.comment"
                placeholder="Write a comment..."
            ></textarea>
            <button type="submit">Submit</button>
        </form>
        <div v-for="request in requests" :key="request.id">
            {{ request.comment }}
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    requests: Array,
});

const form = useForm({
    comment: "",
});

function submit() {
    form.post("/requests", {
        onSuccess: () => {
            // Optionally, do something on success, like resetting the form
            form.reset("comment");
        },
    });
}
</script>
