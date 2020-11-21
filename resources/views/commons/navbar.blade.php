<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div id="navbar" class="container-fluid">
           
            <div class="navbar-header">
                
                <!--タイトル-->
                <a class="navbar-brand" href="/">NecoNeco</a>
                
                 <!--猫のアニメ-->
                <div class="loop_wrap">
                    <p><img class="cat_walk" style="position: relative;cursor: pointer;" src="https://hige-oji-s3-bucket.s3.amazonaws.com/neconeco2020/favicon/cat_walk2_small.gif"></p>
                </div>
                
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                
                <span class="sr-only">Toggle navigation</span>
                    <!--ハンバーガーメニュー3本線-->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div><!-- /.navbar-header -->  
            
            
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                 
                 @if(Auth::check())
                    <ul class="nav navbar-nav">
                    <!--検索バー-->
                        <li>
                            <form id="search-box" action="/microposts/search" method="GET">
                              　<div id="search_field" class="input-group">
                                    <input  type="text" class="form-control" name="search_words"  placeholder=",でOR検索">
                                    <span class="input-group-btn">
                                    	<button type="submit" class="btn btn-default">Search</button>
                                    </span>
                                </div>
                            </form>
                        </li>
                    </ul>
                    <!--右よりのボタンたち-->
                    <ul id="btns" class="nav navbar-nav navbar-right">
                        <li class="nav-item {{ Request::is('usage') ? 'activated' : '' }}"><a class="nav-link" href="/usage">Usage</a></li>
                        <li class="nav-item {{ Request::is('/') ? 'activated' : '' }}"><a class="nav-link" href="/">Cat Photos</a></li> 
                        <li class="nav-item {{ Request::is('microposts/all_map') ? 'activated' : '' }}">{!! link_to_route('microposts.all_map','Photos Map', ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item {{ Request::is('users') ? 'activated' : '' }}">{!! link_to_route('users.index','Other Users', ['class' => 'nav-link']) !!}</li>
                        <li class="nav-item {{ Request::is('microposts/create') ? 'activated' : '' }}">{!! link_to_route('microposts.create','New Post', ['class' => 'nav-link']) !!}</li>
                        <li id="dropdown1" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>{!! link_to_route('users.show', 'My profile', ['id'=>Auth::id()]) !!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!! link_to_route('logout.get', 'Logout') !!}</li>
                            </ul>
                        </li>
                     </ul>   
            </div><!-- /.collapse -->
            @else
            <!--<ログアウトした時のボタン>-->
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item {{ Request::is('usage') ? 'activated' : '' }}"><a href="/usage">Usage</a></li>
                    <li class="nav-item {{ Request::is('signup') ? 'activated' : '' }}">{!! link_to_route('signup.get', 'Signup', ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item {{ Request::is('login') ? 'activated' : '' }}">{!! link_to_route('login', 'Login', ['class' => 'nav-link']) !!}</li>
                </ul>
            </div><!-- /.collapse -->
            @endif
            
        </div><!-- /.container-fluid -->
    </nav>
</header>