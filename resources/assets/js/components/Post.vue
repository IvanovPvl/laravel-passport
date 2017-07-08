<template>
    <div class="row">
        <div class="jumbotron post">
            <h3>
                <router-link :to="{ name: 'PostDetailPage', params: { id: post.id } }">
                    {{ post.title }}
                </router-link>
            </h3>
            <p>{{ post.content }}</p>
            <span>Posted by {{ post.user.name }} at {{ post.created_at }}</span>
        </div>
    </div>
</template>

<script>
    export default {
      props: ['post']
    }
</script>