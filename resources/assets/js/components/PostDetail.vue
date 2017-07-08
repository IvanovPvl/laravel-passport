<template>
    <div class="jumbotron">
        <div class="row post-detail">
            <h2>{{ post.title }}</h2>
            <p>{{ post.content }}</p>
            <div>Posted by {{ post.user.name }} at {{ post.created_at }}</div>
        </div>

        <div class="row">
            <strong>Comments:</strong>
            <div v-for="comment in post.comments">
                <comment :comment="comment"></comment>
            </div>
        </div>

        <div class="row">
            <form class="new-comment col-md-6" v-if="canComment()" @submit.prevent="saveComment()" method="post" action="">
                <div class="form-group">
                    <label for="comment-content"></label>
                    <textarea rows="3" v-model="newComment.content" class="form-control" id="comment-content" placeholder="Input comment" required></textarea>
                </div>
                <button class="btn btn-sm btn-info" :disabled="!newComment.content || commenting" type="submit">Comment</button>
            </form>

            <div v-if="!canComment()">
                Please <a class="btn btn-sm btn-primary" href="/login">login</a> to comment this post.
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      props: ['post'],
      data() {
        return {
          newComment: {
            content: null,
          },
          commenting: false,
        }
      },
      methods: {
        canComment() {
          return Laravel.hasOwnProperty('Auth');
        },
        saveComment() {
          const vm = this;
          vm.commenting = true;

          axios.post('/api/posts/' + vm.post.id + '/comments', {
            content: vm.newComment.content,
            'post_id': vm.post.id,
            'user_id': Laravel.Auth.id,
          }).then(res => {
            vm.newComment = {
              content: null,
            };
            vm.post.comments.unshift(res.data);
            vm.commenting = false;
          }).catch(err => {
            console.error(err);
            vm.commenting = false;
          })
        },
      }
    }
</script>