@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-header">
                            {{ $thread->title.' by '.$thread->user->name }}
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>


                    {{--//reply form--}}

                    <hr/>


                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>This thread was published {{ $thread->created_at->diffForHumans() }}
                                by <a href="/profiles/{{ $thread->user->name }}">{{ $thread->user->name }}</a>,
                                and currently
                                have <span
                                        v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}
                            </p>

                            @can ('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">Delete Thread</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>
@endsection
