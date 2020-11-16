<header>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<!--<div class="container-fluid">-->
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">NecoNeco</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!--<ul class="nav navbar-nav">-->
				<!--	<li class="active"><a href="#">Link</a></li>-->
				<!--	<li><a href="#">Link</a></li>-->
				<!--	<li class="dropdown">-->
				<!--		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>-->
				<!--		<ul class="dropdown-menu">-->
				<!--			<li><a href="#">Action</a></li>-->
				<!--			<li><a href="#">Another action</a></li>-->
				<!--			<li><a href="#">Something else here</a></li>-->
				<!--			<li class="divider"></li>-->
				<!--			<li><a href="#">Separated link</a></li>-->
				<!--			<li class="divider"></li>-->
				<!--			<li><a href="#">One more separated link</a></li>-->
				<!--		</ul>-->
				<!--	</li>-->
				<!--</ul>-->
				
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
                                <li class="divider"></li>
                                <li>{!! link_to_route('logout.get', 'Logout') !!}</li>
                            </ul>
                        </li>
                    @else
                        <li>{!! link_to_route('signup.get', 'Signup') !!}</li>
                        <li>{!! link_to_route('login', 'Login') !!}</li>
                    @endif
				</ul>
				@if(Auth::check())
                    <!--//serach-bar-->
                    <form class="navbar-form" action="/microposts/search" method="GET" role="search">
    					<div id="search_field" class="input-group">
    						<input type="text" class="form-control" name="search_words" placeholder="search">
    						<span class="input-group-btn">
    							<button type="reset" class="btn btn-default">
    								<span class="glyphicon glyphicon-remove">
    									<span class="sr-only">Close</span>
    								</span>
    							</button>
    							<button type="submit" class="btn btn-default">
    								<span class="glyphicon glyphicon-search">
    									<span class="sr-only">Search</span>
    								</span>
    							</button>
    						</span>
    					</div>
    				</form>
				@endif
			</div><!-- /.navbar-collapse -->
		<!--</div><!-- /.container-fluid -->
	</nav>
	
	<!--<div class="container">-->
 <!--   	<div class="row">-->
 <!--   		<div class="alert alert-info">-->
 <!--               <strong>Alerts Dont Work on Bootsnipp!</strong> So when you hit enter or submit this form your result will show up in the green box below!-->
 <!--           </div>-->
 <!--           <div class="alert alert-success">-->
 <!--               <strong>Your Result!</strong> <span id="showSearchTerm"></span>-->
 <!--           </div>-->
 <!--   </div>-->
	
</header>