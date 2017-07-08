<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form class="new-post" v-if="canCreatePost()" @submit.prevent="savePost()" method="post" action="">
                    <div class="form-group">
                        <label for="post-title">Title</label>
                        <input v-model="newComment.title" type="text" class="form-control" id="post-title" placeholder="Input title" required>
                    </div>
                    <div class="form-group">
                        <label for="post-content">Content</label>
                        <textarea rows="3" v-model="newComment.content" class="form-control" id="post-content" placeholder="Input content" required></textarea>
                    </div>
                    <button class="btn btn-sm btn-info" :disabled="!newComment.title || !newComment.content || commenting" type="submit">Comment</button>
                </form>

                <div v-if="!canCreatePost()">
                    Please <a class="btn btn-sx btn-primary" href="/login">login</a> to create post.
                </div>
            </div>
        </div>
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
        },
        newComment: {
          title: null,
          content: null,
        },
        commenting: false,
      }
    },
    mounted() {
      axios.get('/api/posts').then(res => {
        this.posts = res.data;
      }).catch(err => {
        console.error(err);
      })
    },
    methods: {
      canCreatePost() {
        return Laravel.hasOwnProperty('Auth');
      },
      savePost() {
        let vm = this;
        vm.commenting = true;

        axios.post('/api/posts', {
          title: vm.newComment.title,
          content: vm.newComment.content,
          'user_id': Laravel.Auth.id,
        }).then(res => {
          vm.newComment = {
            title: null,
            content: null,
          };
          vm.posts.data.unshift(res.data);
          vm.commenting = false;
        }).catch(err => {
          console.error(err);
          vm.commenting = false;
        })
      }
    }
  }
</script>