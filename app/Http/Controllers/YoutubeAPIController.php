<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class YoutubeAPIController extends Controller
{

  public function videos()
  {
    $options = ['chart' => 'mostPopular', 'maxResults' => 16];
    $regionCode = 'MA';
    $selectedCategory = 0;

    if (\Input::has('page')) {
      $options['pageToken'] = \Input::get('page');
    }

    if (\Input::has('category')) {
      $selectedCategory = \Input::get('category');
      $options['videoCategoryId'] = $selectedCategory;
    }

    $youtube = \App::make('youtube');
    $categories = $youtube->videoCategories->listVideoCategories('snippet', ['regionCode' => $regionCode])->getItems();
    $videos = $youtube->videos->listVideos('id, snippet', $options);

    return view('videos', ['videos' => $videos, 'categories' => $categories, 'selectedCategory' => $selectedCategory]);
  }

  public function video($id)
  {
    $options = ['maxResults' => 1, 'id' => $id];

    $youtube = \App::make('youtube');
    $videos = $youtube->videos->listVideos('id, snippet, player, contentDetails, statistics, status', $options);
    $relatedVideos = $youtube->search->listSearch("snippet",
                                                  ['maxResults' => 16, 'type' => 'video', 'relatedToVideoId' => $id]);

    if (count($videos->getItems()) == 0) {
      return redirect('404');
    }

    return view('video', ['video' => $videos[0], 'relatedVideos' => $relatedVideos]);
  }

  public function search()
  {
    if (!\Input::has('query')) {
      return view("search");
    }

    $options = ['maxResults' => 16, 'q' => \Input::get("query")];
    if (\Input::has('page')) {
      $options['pageToken'] = \Input::get('page');
    }

    $youtube = \App::make('youtube');
    $videos = $youtube->search->listSearch("snippet", $options);

    // after video ends, use relatedToVideoId for suggestions
    return view("search", ['videos' => $videos, 'query' => \Input::get('query')]);
  }
}
