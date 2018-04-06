@component('profiles.activities.activity');

@slot('heading')
    {{ $profileUser->name }} favourited a reply
@endslot

@slot('body')
    <a href="{{ $activity->subject->favorited->path() }}">{{ $activity->subject->favorited->thread->title }}</a>
@endslot

@endcomponent