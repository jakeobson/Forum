<template>
    <div class="card" :id="'reply-'+id">
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
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Submit</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer" v-if="canUpdate">
            <!--@can('update', $reply)-->
            <button class="btn btn-xs" @click="editing = true">Edit</button>

            <button class="btn btn-warning btn-xs" @click="destroy">
                Delete
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
                body: this.data.body
            }
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
                // return this.data.user_id == window.App.user.id;
            },
            ago() {
                return moment(this.data.created_at).fromNow();
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Updated a reply');
            },
            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            }
        }
    }
</script>