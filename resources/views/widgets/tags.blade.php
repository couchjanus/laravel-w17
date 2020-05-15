@if($data)
<div class="card my-4">
        <h5 class="card-header">Tags Cloud</h5>
        <div class="card-body">
             @foreach($data as $item)
             <span class="badge badge-pill badge-danger"><a href="">{{ $item->name }}</a></span>
           @endforeach
        </div>
</div>
@endif