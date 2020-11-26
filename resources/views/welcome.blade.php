@extends('layouts.for_welcome')

@section('content')

    <section>
        <div id="welcome" class="center jumbotron">
            <div id="welcome-text" style="text-align: center;">
                <h1  style="font-weight: normal;">NecoNeco</h1>
                <p>〜撮影した猫の画像を共有するSNS〜</p>
                <p style="margin-bottom:20px;">猫かどうかはAIが判定します</p>
                {!! link_to_route('signup.get', 'Sign up now !', null, ['class' => 'btn btn-lg btn-transparent', 'id'=>'signup-btn']) !!}
            </div>
        </div>
    </section>
             
    <section>
    	<ul>
    	@foreach ($microposts as $micropost)
       		<img class="cat_image" src="{{ secure_asset($micropost->image_path)}}"></a>
    	@endforeach
    	</ul>
    	{!! $microposts->render() !!}
    </section>
        
@endsection