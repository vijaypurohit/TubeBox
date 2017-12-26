@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-warning">
                    <div class="panel-heading"><strong>Channel settings</strong> <span class="glyphicon glyphicon-fire"></span> </div>

                    <div class="panel-body">


                        @if(Session::has('status'))
                            <div class="alert alert-success"><em> {!! session('status') !!}</em></div>
                        @endif

                        <form action="/channel/{{ $channel->slug }}/edit" method="post" enctype="multipart/form-data">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $channel->name }}">

                                @if ($errors->has('name'))
                                    <div class="help-block">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="slug">Unique URL</label>
                                <div class="input-group">
                                    <div class="input-group-addon">{{ config('app.url') }}/channel/</div>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                                </div>

                                @if ($errors->has('slug'))
                                    <div class="help-block">
                                        {{ $errors->first('slug') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>

                                @if ($errors->has('description'))
                                    <div class="help-block">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="image">Channel image</label>
                                <input type="file" name="image" id="image">
                            </div>

                                @if ($errors->has('image'))
                                    <div class="help-block">
                                        {{ $errors->first('image') }}
                                    </div>
                                @endif

                            <button id="channel-update" class="btn btn-default" type="submit">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                        </form>
                        @if($flash = session('channelUpdate'))
                            <div id="flash-message" class="alert alert-success" role="alert">
                                {{$flash}}  <a href="/channel/{{$channel->slug}}">Go to your Channel</a>
                            </div>
                        @endif
{{--<div class="well">--}}
    {{--<div class="row">--}}
        {{--<div class="class-sm-3 col-md-pull-9">--}}
            {{--<div class="progress" v-if="!processed">--}}
                {{--<div class="progress-bar" style=" width: 50%; ">--}}
                    {{--<span class="glyphicon glyphicon-refresh" ></span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="class-sm-9">--}}
            {{--<button type="button" class="btn btn-default" >--}}
                {{--<span class="glyphicon glyphicon-refresh" ></span>--}}
            {{--</button>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
