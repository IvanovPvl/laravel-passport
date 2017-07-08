<template>
    <div class="comment">
        <div>{{ comment.content }}</div>
        <div>Commented by {{ comment.user.name }} at {{ comment.created_at }}</div>
        <button v-if="canDeleteComment()" v-on:click="deleteComment(comment.id)" class="btn btn-sm btn-danger">Delete</button>
    </div>
</template>

<script>
    export default {
      props: ['comment', 'post_id'],
      methods: {
        canDeleteComment() {
          return Laravel.Auth != undefined && Laravel.Auth.id == this.comment.user.id;
        },
        deleteComment(id) {
          const vm = this;
          axios.delete(`/api/posts/${this.post_id}/comments/${this.comment.id}`).then(() => {
            vm.$emit('commentDeleted', { id });
          }).catch(err => {
            console.error(err);
          });
        }
      }
    }
</script>