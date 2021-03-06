@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4">
            @if (Storage::disk('public')->has(Auth::user()->name.'-'.Auth::user()->id.'.jpg'))
            <img src="{{ route('account.image', ['filename'=> Auth::user()->name.'-'.Auth::user()->id.'.jpg'])}}" class="img-responsive"
                style="width: 100%;">
            @else
            <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" class="img-rounded img-responsive" alt="Cinque Terre"
                style="
                width: 100%;">
            @endif

            <br>
            <form method="POST" action="{{route('account.save')}}" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <br>
                <input onChange="this.form.submit()" style="display:none" type="file" name="image" class="form-control-file" id="image">
                <label style="float:right" class="image-input" for="image"> Upload </label>
            </form>
            <div class="clearfix"></div>
            <hr>
            <div class="container">
                @include('inc.messages')

                <div class="panel panel-default">
                    @if(count($listings)) @foreach($listings as $listing)
                    <div class="panel-heading">
                        <span class="pull-right">
                        </span> @endforeach @else
                        <div class="panel-heading">
                            <span class="pull-right">
                            </span>
                    @endif
                            <div class="panel-body">
                                @if(count($listings))
                                <table class="table table-borderless table-sm">
                                    @foreach($listings as $listing)
                                    <tr>
                                        <td>Name: {{$listing->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Bio: {{$listing->bio}}</td>
                                    </tr>
                                    <tr>
                                        <td>Location: {{$listing->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Website: {{$listing->website}}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="EditProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">About Me</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                                </div>
                                <form method="POST" action="/edit" class="form-horizontal">

                                    {{ csrf_field() }}

                                    <div class="form-group">


                                </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">

                    <div style="text-align:center; float:left" class="dropdown show">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                              Following
                          </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach(app\Http\Controllers\HomeController::getFollowingList() as $name)
                            <a class="dropdown-item" href="#">{{$name}}</a> @endforeach
                        </div>
                    </div>
                    <div style="text-align:center; float:right" class="dropdown show">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Followers
                          </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach(app\Http\Controllers\HomeController::getFollowersList() as $name)
                            <a class="dropdown-item" href="#">{{$name}}</a> @endforeach
                        </div>
                    </div>



                </div>
            </div>


            <div class="col-md-8">
    @include('common.errors') {{-- @if ($id) --}}
                <form method="POST" action="{{ route('create')}}" class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Tweet Name -->
                    <div class="form-group">
                        <label for="tweet" class="col-sm-3 control-label">What's happening?</label>

                        <div class="col-sm-12">
                            <input type="text" onkeyup="countCharacters();" name="tweet" id="tweet-name" class="form-control" maxlength="140">
                            <span id="chars">140</span> /140
                        </div>
                        <div class="col-sm-12">
                        </div>
                        <script>
                            var el;
                            function countCharacters() {
                              var textEntered, countRemaining, counter;
                              textEntered = document.getElementById('tweet-name').value;
                              counter = (140 - (textEntered.length));
                              countRemaining = document.getElementById('chars');
                              countRemaining.textContent = counter;
                            }
                            el = document.getElementById('tweet-name');
                            el.addEventListener('keyup', countCharacters, false);
                        </script>
                    </div>

                    <!-- Add Tweet Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tweet
                            </button>

                            <a href="home/Photos/create" class="btn btn-primary btn-xs">Tweet Image</a></span>

                            <button class="btn btn-primary" type="button" onclick="window.location='{{ url('/feed') }}'">
                            View Feed
                          </button>
                     @if(count($listings)) @foreach($listings as $listing)
                            <a href="/listings/{{$listing->id}}/edit" class="btn btn-primary btn-xs">Edit Profile</a>
                            </span>
                            @endforeach @else
                            <a href="/listings/create" class="btn btn-primary btn-xs">Edit Profile</a> @endif
                        </div>
                    </div>
                </form>
                {{-- @endif --}}

                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong> {{app\Http\Controllers\HomeController::getFollowersCount()}} </strong></h2>
                            <p><strong>Followers</strong></p>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong>{{app\Http\Controllers\HomeController::getFollowingCount()}}</strong></h2>
                            <p><strong>Following</strong></p>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong>{{count($tweets)}}</strong></h2>
                            <p><strong>Tweets</strong></p>
                        </div>
                    </div>
                </div>
                @if (count($tweets) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Your Posts
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">

                            <tbody>
                                @foreach ($tweets as $tweet)
                                <thead>
                                    <th>{{$tweet->published_at}}</th>
                                    <th>&nbsp;</th>
                                </thead>
                                    <tr>
                                        <!-- Task Name -->
                                        <td class="table-text">
                                            <div>{{ $tweet->tweet_text }}</div>
                                        </td>
                                        @if ( empty ( $tweet->photo ) )
                                        <td>
                                            <form method="POST" action="{{ route('delete', ['id' => $tweet->id])}}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-dark"> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                     <tr>
                                        <td>
                                            <a href="/photos/{{$tweet->photo_id}}">
                                                <img class="thumbnail" src="/storage/photos/{{$tweet->photo}}">
                                            </a>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('deletePhoto', ['id' => $tweet->id])}}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-dark"> Delete</button>
                                            </form>
                                        </td>
                                     </tr>
                                @endif
                                <tr>
                                    <td>
                                        {{ $tweet->like_cnt }} Like
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>


        </div>
    </div>
@endsection
