<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <div class="col-md-12">
                <div class="col-md-3">
                    <img src="/citube_logo.png" style="margin-top: 14px" class="img-circle" width="20" height="20" />
                </div>
                <div class="col-md-7">
                    <a class="navbar-brand" href="{{ url('/') }}"><strong>{{ config('app.name', 'CiTube') }}</strong>
                    </a>
                </div>
            </div>

        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <form action="/search" method="get" class="navbar-form navbar-left">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search" value="{{ Request::get('q') }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>

            </form>

            <ul class="nav navbar-nav">
                &nbsp;&nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="{{ url('/home') }}"> <span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> DashBoard</a></li>
                    <li><a href="{{ url('/upload') }}"> <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Upload</a></li>
                    <li><a href="{{url('/videos')}}"><span class="glyphicon glyphicon-expand"></span> Your Videos</a></li>
                    <li><a href="{{url('/channel/'.$channel->slug)}}"><span class="glyphicon glyphicon-record"></span> Your Channel</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <div class="row">
                                <img src="{{$channel->getImage()}}" class="img-circle" width="20" height="20" /> <strong> {{ Auth::user()->name }}</strong> <span class="caret"></span>
                            </div>

                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{url('/channel/'.Auth::user()->id.'/subscriptions')}}"><span class="glyphicon glyphicon-check"></span> Subscribed Channels</a>
                                <a href="{{url('/channel/'.$channel->slug.'/edit')}}"><span class="glyphicon glyphicon-wrench"></span> Channel Settings</a>

                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-send"></span> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>