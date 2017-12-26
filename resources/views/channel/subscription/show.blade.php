@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading"><strong>Subscriptions</strong></div>

                    <div class="panel-body">

                        @if ($subscribedChannels->count())

                            <div class="well">
                                @foreach ($subscribedChannels as $channel)
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="/channel/{{ $channel->slug }}">
                                                <img src="{{ $channel->getImage() }}" alt="{{ $channel->name }} image" class="media-object">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <a href="/channel/{{ $channel->slug }}" class="media-heading">{{ $channel->name }}</a>

                                            <ul class="list-inline">
                                                <li class="video__disabled-red">
                                                    {{ $channel->subscriptionCount() }} {{ str_plural('subscriber', $channel->subscriptionCount()) }}
                                                </li>
                                                <li class="video__inline-show">
                                                    {{ $videoCount=$channel->videos()->visible()->count() }} {{ str_plural('video', $videoCount) }}
                                                </li>
                                                <li class="video__inline-show">
                                                    {{ $channel->totalVideoViews() }} video {{ str_plural('view', $channel->totalVideoViews()) }}
                                                </li>
                                                <li class="video__inline-show">
                                                    {{ $channel->totalVideoUpVotes() }} {{ str_plural('upVote', $channel->totalVideoUpVotes()) }}  on Videos
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
