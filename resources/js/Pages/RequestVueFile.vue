<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    requests: Array,
    titles: Array, // Include the titles prop
});

const form = useForm({
    comment: "",
    artist_song_id: null, // Add artist_song_id field
});

const editForm = useForm({
    id: null,
    comment: "",
    artist_song_id: null, // Add artist_song_id field
});

const showModal = ref(false);
const searchQuery = ref("");
const editSearchQuery = ref("");
const showSuggestions = ref(true);
const showEditSuggestions = ref(true);

const filteredSuggestions = computed(() => {
    if (searchQuery.value) {
        return props.titles.filter(title =>
            title.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }
    return [];
});

const filteredEditSuggestions = computed(() => {
    if (editSearchQuery.value) {
        return props.titles.filter(title =>
            title.name.toLowerCase().includes(editSearchQuery.value.toLowerCase())
        );
    }
    return [];
});

function handleSuggestionClick(suggestion) {
    searchQuery.value = suggestion.name;
    form.artist_song_id = suggestion.id; // Set artist_song_id for form
    showSuggestions.value = false;
}

function handleEditSuggestionClick(suggestion) {
    editSearchQuery.value = suggestion.name;
    editForm.artist_song_id = suggestion.id; // Set artist_song_id for edit form
    showEditSuggestions.value = false;
}

function clearSearch() {
    searchQuery.value = "";
    showSuggestions.value = false;
    form.artist_song_id = null; // Clear artist_song_id when search is cleared
}

function clearEditSearch() {
    editSearchQuery.value = "";
    showEditSuggestions.value = false;
    editForm.artist_song_id = null; // Clear artist_song_id when search is cleared
}

function submit() {
    form.post("/requests", {
        onSuccess: () => {
            form.reset("comment");
            form.artist_song_id = null; // Reset artist_song_id after submission
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
    const request = props.requests.find(request => request.id === id);
    editForm.id = id;
    editForm.comment = request.comment;
    editForm.artist_song_id = request.artist_song_id;
    editSearchQuery.value = request.artist_song ? request.artist_song.songs.name : ''; // Set initial search query in the edit form
    showModal.value = true;
}

function updateComment() {
    Inertia.put(`/requests/${editForm.id}`, {
        comment: editForm.comment,
        artist_song_id: editForm.artist_song_id,
    }, {
        onSuccess: () => {
            showModal.value = false;
            editForm.reset();
            clearEditSearch();
        },
    });
}

function handleClickOutside(event) {
    const searchBox = document.querySelector(".search-box");
    if (searchBox && !searchBox.contains(event.target)) {
        showSuggestions.value = false;
    }
    const editSearchBox = document.querySelector(".edit-search-box");
    if (editSearchBox && !editSearchBox.contains(event.target)) {
        showEditSuggestions.value = false;
    }
}

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>

<template>
    <div class="container">
        <form @submit.prevent="submit" class="form">
            <div class="form-group search-group">
                <input type="text" v-model="searchQuery" @focus="showSuggestions = true" class="search-box"
                    placeholder="Search for a song or artist..." />
                <button type="button" class="clear-button" @click="clearSearch">×</button>
                <ul v-if="searchQuery && showSuggestions && filteredSuggestions.length" class="suggestions-list">
                    <li v-for="suggestion in filteredSuggestions" :key="suggestion.id"
                        @click="handleSuggestionClick(suggestion)">
                        {{ suggestion.name }}
                    </li>
                </ul>
            </div>
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
                    <div v-if="request.artist_song" class="song-name">
                        <span class="artist-text"><strong>Song:</strong> {{ request.artist_song.songs.name }}</span>
                    </div>
                    <div v-if="request.artist_song" class="artist-name">
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
                    <div class="form-group search-group">
                        <input type="text" v-model="editSearchQuery" @focus="showEditSuggestions = true"
                            class="edit-search-box" placeholder="Search for a song or artist..." />
                        <button type="button" class="clear-button" @click="clearEditSearch">×</button>
                        <ul v-if="editSearchQuery && showEditSuggestions && filteredEditSuggestions.length"
                            class="suggestions-list">
                            <li v-for="suggestion in filteredEditSuggestions" :key="suggestion.id"
                                @click="handleEditSuggestionClick(suggestion)">
                                {{ suggestion.name }}
                            </li>
                        </ul>
                    </div>
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

textarea.comment-box,
input.search-box,
input.edit-search-box {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

input.search-box {
    margin-bottom: 10px;
}

.search-group {
    position: relative;
}

.clear-button {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #999;
}

.clear-button:hover {
    color: #666;
}

ul.suggestions-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    width: 100%;
    top: calc(100% + 5px);
    z-index: 1;
}

ul.suggestions-list li {
    padding: 10px;
    cursor: pointer;
}

ul.suggestions-list li:hover {
    background-color: #f0f0f0;
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

/* Ensure edit search box matches the width of textarea */
input.edit-search-box {
    margin-bottom: 10px;
}
</style>