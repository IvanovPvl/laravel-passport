<template>
    <div class="container">
        <post-detail :post="post"></post-detail>
    </div>
</template>

<script>
    export default {
      props: ['id'],
      data() {
        return {
          post: {
            user: {
              name: null
            }
          }
        }
      },
      mounted() {
        axios.get('/api/posts/' + this.id).then(res => {
          this.post = res.data;
        }).catch(err => {
          console.err(err);
        })
      },
      canComment() {
        return Laravel.hasOwnProperty('Auth');
      }
    }
</script>