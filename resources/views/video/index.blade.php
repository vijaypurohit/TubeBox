@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading"> <strong>Videos</strong> <span class="glyphicon glyphicon-facetime-video"></span> </div>

                    <div class="panel-body">
                        @if ($videos->count())
                            @foreach ($videos as $video)

                                <div class="well">

                                    <div class="row">

                                        <div class="col-sm-3">
                                            <a href="/videos/{{ $video->uid }}">
                                                <img src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} thumbnail" class="img-responsive">
                                            </a>
                                        </div>

                                        <div class="col-sm-9">
                                            <a href="/videos/{{ $video->uid }}"><strong>{{ $video->title }}</strong> </a>

                                            <div class="row">

                                                <div class="col-sm-5">
                                                    <p class="muted">
                                                        @if (!$video->isProcessed())
                                                            Processing ({{ $video->processedPercentage() ? $video->processedPercentage() . '%' : 'Starting up' }})
                                                            <encode-percentage video-uid="{{ $video->uid }}" old-value="{{ $video->processedPercentage()}}"></encode-percentage>
                                                        @else
                                                            <span>{{ $video->created_at->toDayDateTimeString() }}</span>
                                                        @endif
                                                    </p>
                                                    
                                                    <form action="/videos/{{ $video->uid }}" method="post">
                                                        {{--Edit video Link--}}
                                                        <a href="/videos/{{ $video->uid }}/edit" class="btn btn-default">Edit</a>
                                                        {{--Delete Video Button--}}
                                                        <button type="submit" class="btn btn-default">Delete</button>

                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>

                                                </div>

                                                <div class="col-sm-7">
                                                    <p class="{{ ucfirst($video->visibility) != 'Public' ? 'video__disabled-red' : '' }}">{{ ucfirst($video->visibility)}}</p>
                                                    <ul class="list-inline">
                                                    <li class="video__inline-show">   {{ $video->viewCount() }} {{ str_plural('view', $video->viewCount()) }}</li> &nbsp;
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

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $videos->links() }}
                        @else
                            <p>You have no videos.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
