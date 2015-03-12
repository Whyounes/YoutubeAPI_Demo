@extends("layouts.master")

@section("title")
Videos
@endsection

@section("assets_header")
    {!! Html::style('css/main.css') !!}
@endsection

@section("content")
<div class="container">
    <h3>Popular Videos </h3>
    <hr/>
    {!! Form::open(['route' => 'videos', 'name' => 'formCategory', 'class' => 'form-inline']) !!}
        <label for="category">Filter by category: </label>
        <select name="category" id="category" class="form-control" onchange="this.form.submit()">
            <option value="0">All</option>
            @foreach($categories as $category)
                <option value="{{ $category->getId() }}" @if($selectedCategory == $category->getId()) selected @endif>{{ $category['snippet']['title'] }}</option>
            @endforeach
        </select>
    {!! Form::close() !!}
    <hr/>

    <ul class="list-unstyled video-list-thumbs row">
    @foreach($videos as $video)
        <li class="col-lg-3 col-sm-4 col-xs-6">
            <a href="{{ URL::route('video', ['id' => $video->getId()]) }}" title="{{ $video['snippet']['title'] }}" target="_blank">
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
          <a href="/videos?page={{$videos->getPrevPageToken()}}&category={{ $selectedCategory }}" aria-label="Previous">
            <span aria-hidden="true">Previous &laquo;</span>
          </a>
        </li>
        <li @if($videos->getNextPageToken() == null) class="disabled" @endif>
          <a href="/videos?page={{$videos->getNextPageToken()}}&category={{ $selectedCategory }}" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
</div>

<br/>
@endsection