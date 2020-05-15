@extends('layouts.app')

@section('title')
  @parent
	 | Blog page
@endsection

@section('content')
    <!-- Page Content -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
            <!-- Blog Entries Column -->
            @yield('blogcontent')

            <!-- Sidebar Widgets Column -->
            @include('layouts.partials.blog._sidebar')
            </div>
        </div>
        <!-- /.row -->

    </div>
@endsection

@push('scripts')
@endpush
