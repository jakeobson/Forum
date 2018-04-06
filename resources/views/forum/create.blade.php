@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h2>Create new thread</h2>

                <form method="POST" action="/threads">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="title" placeholder="Thread Title" class="form-control" value="{{ old('title') }}" required />
                    </div>
                    <div class="form-group">
                        <select name="channel_id" class="form-control" required>
                            <option value="">Choose a channel</option>
                            @foreach($channels as $channel)
                                <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id? 'selected': '' }}>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="body" class="form-control" required>{{ old('body') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Create new thread</button>
                </form>
            </div>
        </div>

        @include('partials.errors')

    </div>
@endsection
