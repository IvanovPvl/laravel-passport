<template>
    <div class="container">
        <div v-for="post in posts.data" class="posts">
            <post :post="post"></post>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        posts: {
          data: []
        }
      }
    },
    mounted() {
      axios.get('/api/posts').then(res => {
        this.posts = res.data;
      }).catch(err => {
        console.err(err);
      })
    }
  }
</script>