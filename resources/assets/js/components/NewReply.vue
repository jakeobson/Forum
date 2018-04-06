<template>
    <div>
        <!--@if (Auth::check())-->
        <div v-if="signedIn">

            <hr/>

            <h2>Reply</h2>

            <!--<form method="POST" action="/threads/{{ $thread->channel->slug }}/{{ $thread->id }}/replies">-->
            <div class="form-group">
                <textarea name="body" class="form-control" required v-model="body"></textarea>
            </div>
            <button type="submit" class="btn btn-default" @click="addReply">Add reply</button>
        </div>
        <div v-else>
            <p>You have to <a href="/login">Log in to participate in a discussion</a></p>
        </div>
        <!--</form>-->

        <!--@endif-->
    </div>
</template>


<script>
    export default {
        data() {
            return {
                body: ''
            }
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },
        signedIn() {
            return window.App.signedIn;
        },
        canUpdate() {
            return this.authorize(user => this.data.user_id == user.id);
            // return this.data.user_id == window.App.user.id;
        },
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted');
                        this.$emit('created', data);
                    });
            }
        }
    }
</script>