@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left ">
                                <img src="{{ $channel->getImage() }}" alt="{{ $channel->name }}_image" class="media-object">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><strong> {{ $channel->name }} </strong></h4>


                                <ul class="list-inline">
                                    <li class="video__disabled-red">
                                        <subscribe-button channel-slug="{{ $channel->slug }}"></subscribe-button>
                                    </li>
                                    <li class="video__inline-show">
                                        {{ $channel->totalVideoViews() }} video {{ str_plural('view', $channel->totalVideoViews()) }}
                                    </li>
                                    <li class="video__inline-show">
                                        {{ $channel->totalVideoUpVotes() }} {{ str_plural('upVote', $channel->totalVideoUpVotes()) }} on Videos
                                    </li>
                                    <li class="pull-right">
                                        <a href="{{url('/channel/'.$channel->user_id.'/subscriptions')}}"><span class="glyphicon glyphicon-check"></span> Subscribed Channels</a>
                                    </li>
                                </ul>

                                @if ($channel->description)
                                    <hr>
                                    <p>{{ $channel->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <div class="panel panel-success">
                    <div class="panel-heading"> <span class="glyphicon glyphicon-play-circle"></span> <strong> Videos </strong></div>

                    <div class="panel-body">
                        @if ($videos->count())
                            @foreach ($videos as $video)
                                <div class="well">
                                    @include ('video.partials._video_result', [
                                        'video' => $video
                                    ])
                                </div>
                            @endforeach

                            {{ $videos->links() }}
                        @else
                            <p>{{ $channel->name }} has no videos</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
