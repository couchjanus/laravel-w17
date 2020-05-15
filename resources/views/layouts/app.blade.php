@extends('layouts.master')

@section('title')
  @parent
	 | Home Page
@endsection

@section('styles')
    <!-- Custom styles for this template -->
    @include('layouts.partials.app._styles')
@endsection

@section('meta')
@endsection

@section('page')
<div id="app">
    <div class="container-fluid home-cont1">
        @include('layouts.partials.app._nav')
        @yield('jumbotron')
    </div>
    @yield('info')
    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
    @include('layouts.partials.app._footer')

</div>
@endsection
