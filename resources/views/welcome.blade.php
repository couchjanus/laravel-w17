@extends('layouts.app')

@section('title')
  @parent
	 | Index Page
@endsection

@section('content')

    <div class="container-fluid text-center py-4">
            <div class="py-4">
                <h2 class="h2 text-uppercase">Resent Posts</h2>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div>
            <div class="container">
                <div class="row">
                    @forelse ($latests as $post)
                        <div class="col-12 col-lg-4 col-md-4 px-5">
                            <span class="round-border my-4">
                                <img src="{{$post->cover_path}}">
                            </span>
                            <h3 class="h3 mb-4">{{ $post->stitle }}</h3>
                            <p class="mb-4">{{ $post->description }}</p>
                        </div>
                    @empty
                        <p>No posts yet...</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="container-fluid text-center py-5 home-cont3">
            <button type="button" class="btn btn-warning text-uppercase mb-5"><b>All posts</b></button>
        </div>
        <div class="container-fluid py-5">
            <div class="py-4">
                <h2 class="h2 text-uppercase text-center">Popular Posts</h2>
                <p class="text-center">Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div>
            <div class="container">
                <div class="row">

                  @forelse ($populars as $post)
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                        <div class="container res-shadow res-border">
                            <div class="row p-3">
                                <div class="col-lg-4 col-md-4 col-sm-12 text-center border p-2"><img alt="" src="{{$post->cover_path}}" style="width: 70%;"></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 py-2" style="position: relative;">
                                    <h5 class="mb-1">{{ $post->title }}</h5>
                                    <p class="mb-2"><small>{{ $post->description }}</small></p>
                                    <p>
                                        <small class="">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="star" class="svg-inline--fa fa-star fa-w-18 rating mr-1"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path fill="currentColor"
                                                    d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                                </path>
                                            </svg>
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="star" class="svg-inline--fa fa-star fa-w-18 rating mr-1"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path fill="currentColor"
                                                    d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                                </path>
                                            </svg><svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="star" class="svg-inline--fa fa-star fa-w-18 rating mr-1"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path fill="currentColor"
                                                    d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                                </path>
                                            </svg><svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="star" class="svg-inline--fa fa-star fa-w-18 rating mr-1"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path fill="currentColor"
                                                    d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                                </path>
                                            </svg><svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="star" class="svg-inline--fa fa-star fa-w-18 rating mr-1"
                                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path fill="currentColor"
                                                    d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z">
                                                </path>
                                            </svg></small><small>({{$post->votes}}) Review</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                  @empty
                    <p>No posts yet...</p>
                  @endforelse

                </div>
            </div>
        </div>

        <x-alert />
        @widget('test')

        @widget('categories')
@endsection
