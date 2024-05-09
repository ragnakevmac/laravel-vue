
<template>
  <div>
    <form @submit.prevent="submitComment">
      <textarea v-model="comment" placeholder="Enter your comment" rows="4"></textarea>
      <button type="submit">Submit Comment</button>
    </div>
  </form>
</div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      comment: ''
    }
  },
  methods: {
    async submitComment() {
      try {
        // Here, you might want to send the comment to a backend server
        // This is just a placeholder for whatever HTTP library you are using
        await axios.post('/api/comments', { comment: this.comment });
        this.comment = ''; // Reset comment on successful submission
        alert('Comment submitted successfully!');
      } catch (error) {
        console.error('Failed to submit comment:', error);
        alert('Failed to submit comment. Please try again.');
      }
    }
  }
}
</script>
