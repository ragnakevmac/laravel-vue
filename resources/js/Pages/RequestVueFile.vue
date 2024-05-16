<script setup>
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    requests: Array,
});

const form = useForm({
    comment: "",
});

function submit() {
    form.post("/requests", {
        onSuccess: () => {
            form.reset("comment");
        },
    });
}

function deleteComment(id) {
    if (confirm("Are you sure you want to delete this comment?")) {
        Inertia.delete(`/requests/${id}`, {
            onSuccess: () => {
                // Optionally, do something on success
                console.log(`Comment with id ${id} deleted`);
            },
        });
    }
}

function editComment(id) {
    // Logic to edit comment
    console.log(`Edit comment with id ${id}`);
}
</script>

<template>
    <div class="container">
        <form @submit.prevent="submit" class="form">
            <div class="form-group">
                <textarea
                    v-model="form.comment"
                    class="comment-box"
                    placeholder="Write a comment..."
                ></textarea>
            </div>
            <div class="form-group">
                <div class="button-container">
                    <button type="submit" class="styled-button">Submit</button>
                </div>
            </div>
        </form>
        <div class="comments-container">
            <div class="comment" v-for="request in requests" :key="request.id">
                <span class="comment-text">{{ request.comment }}</span>
                <button class="edit-button" @click="editComment(request.id)">Edit</button>
                <button class="delete-button" @click="deleteComment(request.id)">Delete</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: #f9f9f9;
    padding: 20px;
}

.form, .comments-container {
    width: 100%;
    max-width: 600px;
}

.form-group {
    width: 100%;
    margin: 10px 0;
}

textarea.comment-box {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
    resize: vertical;
    box-sizing: border-box;
}

.button-container {
    display: flex;
    justify-content: center;
}

.styled-button {
    width: auto; /* Make the button width auto */
    padding: 10px 20px; /* Adjust padding to make the button smaller */
    background-color: #4CAF50;
    border: none;
    color: white;
    font-size: 16px;
    text-align: center;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.styled-button:hover {
    background-color: #45a049;
}

.comments-container {
    margin-top: 20px;
}

.comment {
    padding: 15px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px; /* Add space between comments */
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.comment-text {
    word-break: break-word;
    overflow-wrap: anywhere;
    white-space: pre-wrap;
    flex-grow: 1;
    margin-right: 10px;
}

.edit-button, .delete-button {
    border: none;
    color: white;
    font-size: 14px;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.edit-button {
    background-color: #ffeb3b; /* Yellow color */
    margin-right: 5px; /* Add some space between edit and delete buttons */
}

.edit-button:hover {
    background-color: #fdd835;
}

.delete-button {
    background-color: #ff4c4c;
}

.delete-button:hover {
    background-color: #ff3333;
}
</style>
