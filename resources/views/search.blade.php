@extends("layouts.master")

@section("title")
    @if(isset($query))
        Search - {{ $query }}
    @else
        Search
    @endif
@endsection

@section("assets_header")
    {!! Html::style('css/main.css') !!}
@endsection

@section("content")
<div class="container">
    <div class="row">
        <br/>
        <div class="text-center">
{!! Form::open(['route' => 'search', 'class' => 'form-inline']) !!}
    <input type="text" name="query" class="form-control" style="width: 50%;" autofocus="true" value="{{ isset($query)?$query:'' }}"/>
    <input type="submit" class="btn btn-default" value="Search"/>
{!! Form::close() !!}
        </div>
    </div>

    <hr/>

@if(isset($videos))
    <ul class="list-unstyled video-list-thumbs row">
    @foreach($videos as $video)
        <li class="col-lg-3 col-sm-4 col-xs-6">
            <a href="{{ URL::route('video', ['id' => $video->getId()->getVideoId()]) }}" title="{{ $video['snippet']['title'] }}" target="_blank">
                <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="{{ $video['snippet']['title'] }}" class="img-responsive" height="130px" />
                <h2 class="truncate">{{ $video['snippet']['title'] }}</h2>
                <span class="glyphicon glyphicon-play-circle"></span>
            </a>
        </li>
    @endforeach
    </ul>

    <nav class="text-center">
      <ul class="pagination pagination-lg">
        <li @if($videos->getPrevPageToken() == null) class="disabled" @endif>
          <a href="/search?page={{$videos->getPrevPageToken()}}&query={{ $query }}" aria-label="Previous">
            <span aria-hidden="true">Previous &laquo;</span>
          </a>
        </li>
        <li @if($videos->getNextPageToken() == null) class="disabled" @endif>
          <a href="/search?page={{$videos->getNextPageToken()}}&query={{ $query }}" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
@else
    <h2>No result.</h2>
@endif
</div>
@endsection