<template>
    <div>
        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
        </form>

        <img :src="avatar" width="200" height="200"/>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user'],
        components: {ImageUpload},
        data() {
            return {
                avatar: this.user.avatar
            }
        },
        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);

            }
        },
        methods: {
            onLoad(avatar) {
                this.persist(avatar.file);
                this.avatar = avatar.src;
            },
            persist(avatar) {
                let data = new FormData();
                data.append('avatar', avatar);
                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('avatar was uploaded'));
            }
        }
    }

</script>