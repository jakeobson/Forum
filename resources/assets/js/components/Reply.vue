<template>
    <div class="card" :id="'reply-'+id" :class="isBest ? 'bg-success': 'bg-default'">
        <div class="card-header">
            <a :href="'/profiles/'+data.user.name" v-text="data.user.name"></a>
            said: <span v-text="ago"></span>

            <!--@if(Auth::check())-->
            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
            </div>
            <!--@endif-->

        </div>

        <div class="card-body">

            <div v-if="editing">
                <form @submit.prevent="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button class="btn btn-xs btn-primary">Submit</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>
        </div>
        <div class="card-footer">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-xs" @click="editing = true">Edit</button>

                <button class="btn btn-warning btn-xs" @click="destroy">
                    Delete
                </button>
            </div>

            <button class="btn-default btn-xs" @click="markBestReply" v-show="!isBest">
                Best reply
            </button>
            <!--@endcan-->
        </div>
    </div>
</template>


<script>

    import Favorite from './Favorite';
    import moment from 'moment';

    export default {
        props: ['data'],
        components: {Favorite},
        data() {
            return {
                id: this.data.id,
                editing: false,
                body: this.data.body,
                isBest: this.data.isBest,
                reply: this.data
            }
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            }
        },
        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                }).catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.editing = false;

                flash('Updated a reply');

            },
            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },
            markBestReply() {

                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>