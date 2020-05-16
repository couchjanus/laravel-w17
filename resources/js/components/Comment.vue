<template>
    <div class="media mb-4">
        <div class="comment-header d-flex justify-content-between">
          <div class="image"><img src="/images/user.svg" class=" d-flex mr-3 rounded-circle"></div>
          <div class="media-body">
                <h5 class="mt-0"><strong>{{ creator_name }}</strong> | <span class="date">{{ posted_at }}</span></h5>
                <p>{{ comment.body }}</p>
          </div>
        </div>
    </div>
</template>

<script>
  
  export default {
        // name: "Comment",

        props: ['comment'],
        computed: {
          creator_name(){
            return this.comment.creator.name;
          },
          posted_at() {
            return this.comment.created_at;
          },
        }
  }
</script>
