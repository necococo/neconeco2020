@extends('layouts.app')

@section('content')

<div>
	<ul>
	@foreach ($microposts as $micropost)
   		<a class="float" id="{{$micropost->id}}"  href="{{ route('microposts.show', ['id' => $micropost->id]) }}">
   		<img class="cat_image" src="{{ secure_asset($micropost->image_path)}}"></a>
	@endforeach
	</ul>
	{!! $microposts->render() !!}
</div>

<!--<script src="{{ secure_asset('js/store_sort_order.js') }}"></script>-->
@endsection