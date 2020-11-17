<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--タイトル-->
                <a class="navbar-brand" href="/">NecoNeco</a>
            </div>    
                
                    
                     @if(Auth::check())
                     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/usage">Usage</a></li>
                            <li><a href="/">All Cats Photos</a></li> 
                            <li>{!! link_to_route('microposts.all_map','All Photos Map') !!}</li>
                            <li>{!! link_to_route('users.index','Other Users') !!}</li>
                            <li>{!! link_to_route('microposts.create','New Post') !!}</li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>{!! link_to_route('users.show', 'My_profile', ['id'=>Auth::id()]) !!}</li>
                                    <li role="separator" class="divider"></li>
                                    <li>{!! link_to_route('logout.get', 'Logout') !!}</li>
                                </ul>
                            </li>
                        </ul>
                        </div>
                    @else
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/usage">Usage</a></li>
                            <li>{!! link_to_route('signup.get', 'Signup') !!}</li>
                            <li>{!! link_to_route('login', 'Login') !!}</li>
                        </ul>
                        </div>
                    @endif
                    
        <!--</div>-->
    </nav>
</header>