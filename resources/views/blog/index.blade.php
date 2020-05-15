@extends('layouts.blog')

@section('title')
  @parent
	 | Index Blog Page
@endsection

@section('blogcontent')

<!-- Blog Entries Column -->
<div class="col-lg-8 col-md-8 col-sm-12">

  <h1 class="my-4">{{ $title }}</h1>
  @forelse ($posts as $post)
    <!-- Blog Post -->
    <div class="card mb-4">
      <img class="card-img-top" src="{{$post->cover_path}}" alt="Card image cap">
      <div class="card-body">
        <h2 class="card-title">{{ $post->title }}</h2>
        <p class="card-text">{{ $post->description }}</p>
        <a href="{{route('blog.show', $post->slug)}}" class="btn btn-primary">Read More &rarr;</a>
      </div>
      <div class="card-footer text-muted d-flex justify-content-between">
        <span class="lead">
        Posted on {{ date('d-m-Y', strtotime($post->updated_at)) }} by
        <a href="#">{{ $post->user->name }}</a>
        </span>
        <span class="lead">
          Views
              {{ $post->votes }}
        </span>
      </div>
    </div>
  @empty
      <p>No posts yet...</p>
  @endforelse

  <!-- Pagination -->
  {{ $posts->links() }}
</div>

@endsection