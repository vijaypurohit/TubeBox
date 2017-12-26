@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading"><strong> Dashboard </strong> <span class="glyphicon glyphicon-blackboard"></span>  </div>

                <div class="panel-body">
                    @if( $subscriptionVideos->count() )
                         @foreach( $subscriptionVideos as $video)
                             <div class="well">
                                 @include('video.partials._video_result',[
                                    'video' => $video
                                 ])
                             </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-2" >
            <div class="sidebar-module">
                <h4>Subscriptions</h4>
                <ol class="list-unstyled">
                    @if( $subscribedChannels->count() )
                        @foreach( $subscribedChannels as $channel)
                        <li class="video__disabled-red">
                                <a href="/channel/{{ $channel->slug }}">
                                    <img src="{{ $channel->getImage() }}" alt="{{ $channel->name }} image" class="img-circle" >
                                </a>
                                <a href="/channel/{{ $channel->slug }}" class="media-heading">{{ $channel->name }}</a>
                        </li>
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>

@endsection
