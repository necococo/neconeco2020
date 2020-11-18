@extends('layouts.app')

@section('content')
{!! $sql->render() !!}
<ul>
	@foreach ($sql as $micropost)
   		<a class="float" id="{{$micropost->id}}"  href="{{ route('microposts.show', ['id' => $micropost->id]) }}">
   		<img class="cat_image" src="{{ secure_asset($micropost->image_path)}}"></a>
	@endforeach
</ul>

<!--<script src="{{ secure_asset('js/store_sort_order.js') }}"></script>-->
@endsection