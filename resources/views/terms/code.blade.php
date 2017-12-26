@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row row-offcanvas row-offcanvas-right">

            <div class="col-12 col-md-9">

                <div class="jumbotron">
                    <h1>Respect the {{ config('app.name') }} community</h1>
                    <p>We're not asking for the kind of respect reserved for nuns, the elderly and brain surgeons. All we ask is that you don't abuse the site. Every cool, new community feature on {{ config('app.name') }}  involves a certain level of trust. We trust you to be responsible, and millions of users respect that trust. Please be one of them.</p>
                </div>
                <div class="row">
                    <div class="col-6 col-lg-4">
                        <h2>Nudity or sexual content</h2>
                        <p>{{ config('app.name') }} is not for pornography or sexually explicit content. If this describes your video, even if it's a video of yourself, don't post it on {{ config('app.name') }}. Also, please be advised that we work closely with law enforcement agencies and that we report child exploitation</p>
                        {{--<p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>--}}
                    </div><!--/span-->
                    <div class="col-6 col-lg-4">
                        <h2>Harmful or dangerous content</h2>
                        <p>Don't post videos that encourage others to do things that might cause them to get badly hurt, especially children. Videos showing such harmful or dangerous acts may be age-restricted or removed depending on their severity.</p>
                    </div><!--/span-->
                    <div class="col-6 col-lg-4">
                        <h2>Violent or graphic content</h2>
                        <p>It's not acceptable to post violent or gory content that is primarily intended to be shocking, sensational or disrespectful. If you post graphic content in a news or documentary context, please provide enough information to help people understand what's going on in the video. Don't encourage others to commit specific acts of violence.</p>
                    </div><!--/span-->
                    <div class="col-6 col-lg-4">
                        <h2>Copyright</h2>
                        <p>Respect copyright. Only upload videos that you made or that you're authorised to use. Don't upload videos that you didn't make, or use content in your videos that someone else owns the copyright to, such as music tracks, snippets of copyrighted programmes or videos made by other users, without the necessary authorisations.</p>
                    </div><!--/span-->
                    <div class="col-6 col-lg-4">
                        <h2>Hateful content</h2>
                        <p>Our products are platforms for free expression. However, we don't support content that promotes or condones violence against individuals or groups based on race or ethnic origin, religion, disability, gender, age, nationality, veteran status or sexual orientation/gender identity, or whose primary purpose is inciting hatred on the basis of these core characteristics. This can be a delicate balancing act, but if the primary purpose is to attack a protected group, the content crosses the line. </p>
                    </div><!--/span-->
                    <div class="col-6 col-lg-4">
                        <h2>Threats</h2>
                        <p>Things like predatory behaviour, stalking, threats, harassment, intimidation, invading privacy, revealing other people's personal information and inciting others to commit violent acts or to violate the Terms of Use are taken very seriously. Anyone caught doing these things may be permanently banned from {{ config('app.name') }}.</p>
                    </div><!--/span-->
                    <div class="col-6 col-lg-4">
                        <h2>Spam, misleading metadata and scams</h2>
                        <p>Everyone hates spam. Don't create misleading descriptions, tags, titles or thumbnails in order to increase views. It's not acceptable to post large amounts of untargeted, unwanted or repetitive content, including comments and private messages..</p>
                    </div><!--/span-->
                </div><!--/row-->
            </div><!--/span-->
        </div>
    </div>


@endsection
