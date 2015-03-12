@extends("layouts.master")

@section("title")
    Video - {{ $video["snippet"]["title"] }}
@endsection

@section("assets_header")
    {!! Html::style('css/main.css') !!}
@endsection


@section("content")
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <h2>{{ $video["snippet"]["title"] }}</h2>
            </div>

            <div class="row">
                <iframe type='text/html' src='http://www.youtube.com/embed/{{ $video->getId() }}' width='100%' height='500' frameborder='0' allowfullscreen='true'></iframe>
            </div>

            <div class="row">
                (<span>{{ $video["statistics"]["likeCount"] }} <i class="glyphicon glyphicon-thumbs-up"></i></span>)
                (<span>{{ $video["statistics"]["dislikeCount"] }} <i class="glyphicon glyphicon-thumbs-down"></i></span>)
                (<span>{{ $video["statistics"]["favoriteCount"] }} <i class="glyphicon glyphicon-heart"></i></span>)
                (<span>{{ $video["statistics"]["commentCount"] }} <i class="glyphicon glyphicon-bullhorn"></i></span>)
            </div>

            <hr/>

            <div class="row">
                <p>{{ $video["snippet"]["description"] }}</p>
            </div>

        </div>
    </div>
    <hr/>
    <div class="row">
        <h2>Suggestions: </h2>
        <hr/>

        <ul class="list-unstyled video-list-thumbs row">
            @foreach($relatedVideos as $video)
                <li class="col-lg-3 col-sm-4 col-xs-6">
                    <a href="{{ URL::route('video', ['id' => $video->getId()->getVideoId()]) }}" title="{{ $video['snippet']['title'] }}" target="_blank">
                        <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="{{ $video['snippet']['title'] }}" class="img-responsive" height="130px" />
                        <h2 class="truncate">{{ $video['snippet']['title'] }}</h2>
                        <span class="glyphicon glyphicon-play-circle"></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@endsection