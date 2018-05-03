<div class="card">
    <div v-if="editing">
        <div class="card-header">
            <input v-model="form.title" type="text" class="form-control"/>
        </div>

        <div class="card-body">
            <textarea v-model="form.body" class="form-control" rows="10"></textarea>
        </div>
    </div>
    <div v-else>
        <div class="card-header">
            <span v-text="form.title">
                {{ $thread->title}}
            </span>
            by {{$thread->user->name }}

            <img src="{{ $thread->user->avatar }}" width="30" height="30"/>

        </div>

        <div class="card-body" v-text="form.body">

        </div>
    </div>

    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-info btn-xs" @click="editing = true" v-show="! editing">Edit</button>
        <button class="btn btn-primary btn-xs" @click="update" v-show="editing">Update</button>
        <button class="btn btn-default btn-xs" @click="cancel" v-show="editing">Cancel</button>
    </div>
</div>