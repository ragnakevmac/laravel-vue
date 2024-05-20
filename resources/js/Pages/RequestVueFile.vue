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

const editForm = useForm({
    id: null,
    comment: "",
});

const showModal = ref(false);

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
                console.log(`Comment with id ${id} deleted`);
            },
        });
    }
}

function editComment(id) {
    const comment = props.requests.find(request => request.id === id).comment;
    editForm.id = id;
    editForm.comment = comment;
    showModal.value = true;
}

function updateComment() {
    Inertia.put(`/requests/${editForm.id}`, { comment: editForm.comment }, {
        onSuccess: () => {
            showModal.value = false;
            editForm.reset();
        },
    });
}
</script>

<template>
    <div class="container">
        <form @submit.prevent="submit" class="form">
            <div class="form-group">
                <textarea v-model="form.comment" class="comment-box" placeholder="Write a comment..."></textarea>
            </div>
            <div class="form-group">
                <div class="button-container">
                    <button type="submit" class="styled-button">Submit</button>
                </div>
            </div>
        </form>
        <div class="items-container">
            <div class="request-item" v-for="request in requests" :key="request.id">
                <div class="text-container">
                    <div class="song-name">
                        <span class="artist-text"><strong>Song:</strong> {{ request.artist_song.songs.name }}</span>
                    </div>
                    <div class="artist-name">
                        <span class="artist-text"><strong>Artist:</strong> {{ request.artist_song.artists.name }}</span>
                    </div>

                    <div class="comment-container">
                        <span class="comment-text"><strong>Comment:</strong> {{ request.comment }}</span>
                    </div>
                </div>
                <div class="button-container">
                    <button class="edit-button" @click="editComment(request.id)">Edit</button>
                    <button class="delete-button" @click="deleteComment(request.id)">Delete</button>
                </div>
            </div>
        </div>





        <div v-if="showModal" class="modal">
            <div class="modal-content">
                <span class="close-button" @click="showModal = false">&times;</span>
                <form @submit.prevent="updateComment">
                    <div class="form-group">
                        <textarea v-model="editForm.comment" class="comment-box"
                            placeholder="Edit your comment..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="button-container">
                            <button type="submit" class="styled-button">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped>
/* Existing styles */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: #f9f9f9;
    padding: 20px;
}

.form,
.items-container {
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
    width: auto;
    padding: 10px 20px;
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

.items-container {
    margin-top: 20px;
}

.request-item {
    padding: 15px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.text-container {
    flex-grow: 1;
    margin-right: 10px;
}

.artist-text,
.song-name,
.comment-text {
    display: block;
    margin-bottom: 5px;
    word-break: break-word;
    overflow-wrap: anywhere;
    white-space: pre-wrap;
}

.edit-button,
.delete-button {
    border: none;
    color: white;
    font-size: 14px;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
    margin-bottom: 5px;
}

.edit-button {
    background-color: #ffeb3b;
    margin-right: 5px;
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

/* Modal styles */
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    max-width: 500px;
    width: 100%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: relative;
}

.close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #333;
}

.close-button:hover {
    color: #000;
}
</style>