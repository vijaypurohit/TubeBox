<div class="row">
    <div class="col-sm-3">
        <a href="/videos/{{ $video->uid }}">
            <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image" class="img-responsive">
        </a>
    </div>
    <div class="col-sm-9">
        <a href="/videos/{{ $video->uid }}"> <b> {{ $video->title }} </b></a>

        @if ($video->description)
            <p>{{ str_limit($video->description, 72) }}</p>
        @else
            <p class="muted">No description</p>
        @endif

        <ul class="list-inline">
            <li><a href="/channel/{{ $video->channel->slug }}">{{ $video->channel->name }}</a></li>
            <li class="text-default">{{ $video->created_at->diffForHumans() }}</li>
            <li class="video__inline-show">{{ $video->viewCount() }} {{ str_plural('view', $video->viewCount()) }}</li>
            @if ($video->votesAllowed())
                <li class="video__inline-show">   {{ $video->votes()->count() }} {{ str_plural('vote', $video->votes()->count()) }}  &nbsp;</li>
            @else
                <li class="video__disabled-red">Votes disabled</li>
            @endif
            @if ($video->commentsAllowed())
                <li class="video__inline-show" > {{ $video->comments()->count() }} {{ str_plural('comment', $video->comments()->count()) }}</li>
            @else
                <li class="video__disabled-red">Comments disabled</li>
            @endif
        </ul>
    </div>
</div>