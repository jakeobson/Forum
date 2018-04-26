@forelse($threads as $thread)

    <div class="card">
        <div class="card-header">
            <a href="{{ $thread->path() }}">

                @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                    <strong>{{ $thread->title }}</strong>
                @else
                    {{ $thread->title }}
                @endif


            </a>
            <br />
            Written by <a href="/profiles/{{ $thread->user->name }}">{{ $thread->user->name }}</a>
            <strong>
                {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
            </strong>
        </div>

        <div class="card-body">
            {{ $thread->body }}
        </div>
        <div class="card-footer">
            {{ $thread->visits_count }} visits
        </div>
    </div>


@empty

    <p>There are no threads</p>

@endforelse