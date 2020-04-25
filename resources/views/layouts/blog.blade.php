@extends('layouts.master')

@section('title')
  @parent
	 | Blog page
@endsection

@section('styles')
    <!-- Custom styles for this template -->
    @include('layouts.partials.shared._styles')
@endsection

@section('meta')
@endsection
  <!-- Navigation -->
@include('layouts.partials.blog._nav')
@section('page')
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            @yield('content')

            <!-- Sidebar Widgets Column -->
            @include('layouts.partials.blog._sidebar')
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
    <!-- Footer -->
    @include('layouts.partials.blog._footer')

@endsection

@include('layouts.partials.shared._scripts')

@push('scripts')
@endpush
