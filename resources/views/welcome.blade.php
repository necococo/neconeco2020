@extends('layouts.app')

@section('content')
<section>
        <div class="center jumbotron">
            <div class="text-center">
                <h1 style="font-size:4.5vw;">Welcome to the NecoNeco</h1>
                <h3 style="font-size:1.5vw;">〜みつけた猫の画像とその位置共有SNS〜</h3>
                <h3 style="font-size:1.5vw; margin-bottom:20px;">ほんとに猫かどうかはAIが判定するニャン</h3>
                {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
</section>

<section>
    
    
    
</section>

<section>
	<ul>
	@foreach ($microposts as $micropost)
   		<img class="cat_image" src="{{ secure_asset($micropost->image_path)}}"></a>
	@endforeach
	</ul>
	{!! $microposts->render() !!}
</section>

<!--<script src="{{ secure_asset('js/store_sort_order.js') }}"></script>-->
@endsection