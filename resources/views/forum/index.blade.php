@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                @forelse($threads as $thread)

                    <div class="card">
                        <div class="card-header">
                            <a href="{{ $thread->path() }}">
                                {{ $thread->title }}
                            </a>
                            <strong>
                                {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                            </strong>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>


                @empty

                    <p>There are no threads</p>

                @endforelse


                <a href="/threads/create">Create New Thread</a>

            </div>
        </div>
    </div>
@endsection
