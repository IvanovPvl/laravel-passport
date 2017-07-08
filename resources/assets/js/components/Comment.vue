<template>
    <div class="comment">
        <div>{{ comment.content }}</div>
        <div>Commented by {{ comment.user.name }} at {{ comment.created_at }}</div>
    </div>
</template>

<script>
    export default {
      props: ['comment'],
    }
</script>