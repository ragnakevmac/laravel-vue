<template>
    <div>
        <form @submit.prevent="submit">
            <textarea
                v-model="form.comment"
                placeholder="Write a comment..."
            ></textarea>
            <br>
            <button type="submit" class="styled-button">Submit</button>
            <br>
            <br>

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

<style scoped>
.styled-button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
  transition: background-color 0.3s;
}

.styled-button:hover {
  background-color: #45a049;
}
</style>
