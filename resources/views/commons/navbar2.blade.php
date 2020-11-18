<header>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<!--ハンバーガー3本線-->
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
      <a class="navbar-brand" href="/">NecoNeco</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/usage">使い方</a></li>
        @if (Auth::check())
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
        @else
            <li>{!! link_to_route('signup.get', 'Signup') !!}</li>
            <li>{!! link_to_route('login', 'Login') !!}</li>
        @endif
      </ul>
        
      

      <form id="flex-form" class="navbar-form navbar-right" role="search" action="/microposts/search" method="GET">
        <div class="input-group">
          <!--<span class="sr-only">Search</span>-->
          <input type="text" class="form-control" id="form-box" name="search_words"  placeholder="「,」でOR検索">
          <span class="input-group-btn">
              <button type="submit" class="btn btn-success" id='searchBtn'><span class="glyphicon glyphicon-search"><span class="sr-only">Search</span></span></button>
          </span>
        </div>
      </form>
      
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>

</header>