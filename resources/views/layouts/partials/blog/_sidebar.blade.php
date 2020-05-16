<!-- Sidebar Widgets Column -->
<div class="col-lg-4 col-md-4 col-sm-12">

    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">Search</h5>
        <div class="card-body">
          <form action="{{ route('search.result') }}" method="get" class="form-inline mr-auto">@csrf
            <div class="input-group">
                <input type="text" name="query" class="form-control"  value="{{ isset($searchterm) ? $searchterm : ''  }}" placeholder="Search for..." aria-label="Search">
                <span class="input-group-btn">
                    <button class="btn aqua-gradient btn-rounded btn-sm my-0 waves-effect waves-light" type="submit">Go!</button>
                </span>
            </div>
          </form>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">Categories</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                    @foreach($categories as $category)
                        @if ($category->id % 2 == 0)
                            @if ($category->children->count() > 0)
                                <li class="widget-item">
                                    <a class="widget-link" href="{{ route('category.show', $category->id) }}" id="{{ $category->id }}">{{ $category->name }}</a>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($category->children as $cats)
                                            <li><a class="dropdown-item widget-link" href="{{ route('category.show', $cats->id) }}">{{ $cats->name }}</a>
                                            </li>    
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="widget-item">
                                    <a class="widget-link" href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $category)
                        @if ($category->id % 2 != 0)
                            @if ($category->children->count() > 0)
                                <li class="widget-item">
                                    <a class="widget-link" href="{{ route('category.show', $category->id) }}" id="{{ $category->id }}">{{ $category->name }}</a>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($category->children as $cats)
                                            <li><a class="dropdown-item widget-link" href="{{ route('category.show', $cats->id) }}">{{ $cats->name }}</a>
                                            </li>    
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="widget-item">
                                    <a class="nav-link" href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Side Widget -->
    <div class="card my-4">
        <h5 class="card-header">Side Widget</h5>
        <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new
            Bootstrap 4 card containers!
        </div>
    </div>
    @widget('tags')
    
</div>
