<template>
    <div class="row">
        <div class="jumbotron post">
            <h3>
                <router-link :to="{ name: 'PostDetailPage', params: { id: post.id } }">
                    {{ post.title }}
                </router-link>
            </h3>
            <p>{{ post.content }}</p>
            <div>Posted by {{ post.user.name }} at {{ post.created_at }}</div>
            <button v-if="canDeletePost()" v-on:click="deletePost(post.id)" class="btn btn-sm btn-danger">Delete</button>
        </div>
    </div>
</template>

<script>
    export default {
      props: ['post'],
      methods: {
        canDeletePost() {
          return Laravel.Auth !== undefined && Laravel.Auth.id == this.post.user_id;
        },
        deletePost(id) {
          const vm = this;
          axios.delete('/api/posts/' + id).then(() => {
            vm.$emit('postDeleted', { id });
          }).catch(err => {
            console.error(err);
          });
        }
      }
    }
</script>