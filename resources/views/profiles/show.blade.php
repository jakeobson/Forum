@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h3>{{ $profileUser->name }} profile</h3>
                        <small>Since: {{ $profileUser->created_at->diffForHumans() }}</small>

                        {{--@can('update', $profileUser)--}}
                            <br/>

                            <avatar-form :user="{{ $profileUser }}"></avatar-form>

                        {{--@endcan--}}


                    </div>

                    <div class="card-body">

                        @forelse($activities as $date => $activity)

                            <h3 class="page-header">{{ $date }}</h3>

                            @foreach($activity as $record)
                                @if(view()->exists("profiles.activities.{$record->type}"))
                                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                                @endif
                            @endforeach



                        @empty
                            <p>There are no activities</p>

                        @endforelse
                    </div>
                </div>
            </div>

        </div>
@endsection
