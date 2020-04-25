@extends('layouts.blog')

@section('title')
  @parent
	 | Index Blog Page
@endsection

@section('content')

<!-- Blog Entries Column -->
<div class="col-md-8">

  <h1 class="my-4">{{ $title }}</h1>
  @forelse ($posts as $post)
    <!-- Blog Post -->
    <div class="card mb-4">
      <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
      <div class="card-body">
        <h2 class="card-title">{{ $post->title }} {{ $post->category_id }}</h2>
        <p class="card-text">{{ $post->content }}</p>
        <a href="{{route('blog.show', $post->slug)}}" class="btn btn-primary">Read More &rarr;</a>
      </div>
      <div class="card-footer text-muted">
        Posted on {{ $post->updated_at }} by
        <a href="#">{{ $post->user_id }}</a>
      </div>
    </div>
  @empty
      <p>No posts yet...</p>
  @endforelse

  <!-- Pagination -->
  {{ $posts->links() }}
</div>

@endsection