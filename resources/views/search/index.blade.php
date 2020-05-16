@extends('layouts.blog')

@section('blogcontent')

<div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card">
            @if(isset($searchResults))
                @if ($searchResults-> isEmpty())
                    <h2>Sorry, no results found for the term <b>"{{ $searchterm }}"</b>.</h2>
                @else
                <h2>There are {{ $searchResults->count() }} results for the term <b>"{{ $searchterm }}"</b></h2>
                <div class="card-body">
                    @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                        <div class="mb-4">
                            <h5 class="mt-0">Type {{ ucfirst($type) }}</h5>
                            @foreach($modelSearchResults as $searchResult)
                                <dd class="list-group-item my-4">
                                    <a href="{{ $searchResult->url }}" class="search-link">{{ $searchResult->title }}</a>
                                </dd>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                @endif
            @endif
            </div>
</div>
@endsection
