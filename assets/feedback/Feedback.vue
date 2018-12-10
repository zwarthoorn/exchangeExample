<template>
    <div>
        <ul v-if="feedback.length">
            <li v-for="f in feedback" :key="f['@id']">
                {{ f.author }}
                <star-rating :rating="f.rating" :read-only="true"></star-rating>
                {{ f.comment }}
            </li>
        </ul>
        <p v-else>no Feedback Yet</p>

        <p v-if="sent"> Thanks for rating this talk!</p>
        <form v-else @submit.prevent="onSubmit">
            <input v-model="author" name="author" placeholder="Author">
            <star-rating v-model="rating"></star-rating>
            <textarea v-model="comment"
                    name="comment"
                      cols="30"
                      rows="10"
                      placeholder="this talk whas"  ></textarea>
            <input :disabled="!author || !rating || !comment" type="submit">
        </form>
    </div>
</template>

<script>
    export default {
        props: ['sessionId'],
        data() {
            return {feedback:[], author: '', rating:0, comment: '', sent:false}
        },
        created() {
            this.fetchFeedback();
        },
        methods: {
            fetchFeedback(){
                fetch('/api/sessions/'+this.sessionId+'/feedback')
                    .then(response => response.json())
                    .then(data => this.feedback = data['hydra:member'])
            },
            onSubmit() {
                const {sessionId, author, rating, comment} = this;
                fetch('/api/feedback', {
                    method:'POST',
                    headers:{'Content-Type':'application/ld+json'},
                    body: JSON.stringify({session:'/api/sessions/'+sessionId,author,rating,comment})
                })
                    .then(()=> {
                        this.sent = true;
                        this.fetchFeedback();
                    })
            }
        }
    }
</script>