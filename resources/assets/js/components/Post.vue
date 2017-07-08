<template>
    <div class="row">
        <div class="jumbotron">
            <h3>{{ post.title }}</h3>
        </div>
    </div>
</template>

<script>
    export default {
      props: ['post']
    }
</script>