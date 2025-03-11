@if (count($users) > 0)

<ul class="media-list">
@foreach ($users as $user)
    @if($user!=Auth::user())
        <li class="media">
            <div class="media-left">
                <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
            </div>
            
            <div class="media-body">
                
                <div>
                    {{ $user->name }} 
                </div>
                <div>
                    <p>{!! link_to_route('users.show', 'View profile', ['id' => $user->id]) !!}</p>
                </div>
            </div>
        </li>
    @endif
@endforeach
</ul>
{!! $users->render()!!}
<!--<script src="{{ secure_asset('js/store_sort_order.js') }}"></script>-->

@endif