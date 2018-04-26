<template>

    <button v-if="signedIn" :class="classes" @click="toggle">Subscribe to
        a thread
    </button>

</template>

<script>
    export default {

        props: ['active'],
        computed: {
            classes() {
                return ['btn', this.isActive ? 'btn-success' : 'btn-default'];
            }
        },
        data(){
            return{
                isActive: this.active
            }
        },
        methods: {
            toggle() {

                if (window.App.user) {
                    this.isActive ? this.unsubscribe() : this.subscribe();

                    this.isActive = !this.isActive;
                }

            },
            subscribe() {
                axios.post(location.pathname + '/subscriptions');

                flash('Subscribed');
            },
            unsubscribe() {
                axios.delete(location.pathname + '/subscriptions');

                flash('Unsubscribed');
            }
        }

    }
</script>