<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.jpg') }}">

    <!-- CSFR token for ajax call -->
    <meta name="_token" content="{{ csrf_token() }}"/>

    <title>Manage Players</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    {{-- <link rel="styleeheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}

    <!-- icheck checkboxes -->
    <link rel="stylesheet" href="{{ asset('icheck/square/yellow.css') }}">
    {{-- <link rel="stylesheet" href="https://raw.githubusercontent.com/fronteed/icheck/1.x/skins/square/yellow.css"> --}}

    <!-- toastr notifications -->
    {{-- <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="/css/app.css" rel="stylesheet">

    <style>

    </style>


</head>

<body>
<nav class="navbar navbar-default navbar-static-top bg-dark">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">

                <li><a href="{{ url('/teams') }}">Teams</a></li>
                <li><a href="{{ url('/games') }}">Games</a></li>


            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Players</h2>
        </div>
    </div>
    @if($admin)
        <div class="row">
            <div class="col-md-12 text-center"><a href="#" class="add-modal">Add a Player</a></div>
        </div>
    @endif
    <br />

<div class="col-md-9">

    <table class="table table-striped table-hover" id="postTable" style="max-width: 100%;">
        <thead>
        <tr>
            <th class="end"></th>
            <th >Team</th>
            <th> </th>
            <th> </th>
            <th class="end"> </th>
            <th>Offense</th>
            <th> </th>
            <th class="end"> </th>
            <th>Shots</th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th class="end"> </th>
            <th>Transition </th>
            <th> </th>
            <th class="end"> </th>
            <th>Faceoff</th>
            <th> </th>
            <th class="end"> </th>
            <th>Goalie</th>
            <th> </th>
            <th class="end"> </th>
            @if($admin)
                <th> </th>
                <th> </th>
            @endif
        </tr>
        <tr>
            <th class="end">#</th>
            <th>Name</th>
            <th>Team</th>
            <th>position</th>
            <th class="end">Number</th>
            <th>Goal</th>
            <th>Assist</th>
            <th class="end">Points</th>
            <th>Shots</th>
            <th>Shot%</th>
            <th>SOG</th>
            <th>SOG%</th>
            <th>Manup</th>
            <th class="end">Down</th>
            <th>GroundBall</th>
            <th>TO</th>
            <th class="end">CTO</th>
            <th>Win</th>
            <th>Lose</th>
            <th class="end">FO%</th>
            <th>Allowed</th>
            <th>Saved</th>
            <th class="end">Save%</th>
            @if($admin)
                <th>Last updated</th>
                <th>Actions</th>
            @endif
        </tr>
        {{ csrf_field() }}
        </thead>
        <tbody>
        @foreach($players as $indexKey => $player)
            <tr class="item{{$player->id}} @if($player->is_published) warning @endif">
                <td class="col1">{{ $indexKey+1 }}</td>
                <td><a href="{{ URL('').'/player/'.$player->id }}">{{$player->name}}</a></td>
                <td><a href="{{ URL('').'/team/'.$player->team_id }}">{{ \App\Team::findOrFail($player->team_id)->name}}</a></td>
                <td>{{$player->position}}</td>
                <td>{{$player->number}}</td>
                <td>{{ $player->goals }}</td>
                <td>{{ $player->assists }}</td>
                <td class="end">{{ $player->points }}</td>
                <td>{{ $player->shots }}</td>
                <td>{{ $player->shots_percentage }}</td>
                <td>{{ $player->sog }}</td>
                <td>{{ $player->sog_percentage }}</td>
                <td>{{ $player->manup }}</td>
                <td class="end">{{ $player->down }}</td>
                <td>{{ $player->ground_ball }}</td>
                <td>{{ $player->TO }}</td>
                <td class="end">{{ $player->CTO }}</td>
                <td>{{ $player->win }}</td>
                <td>{{ $player->lose }}</td>
                <td class="end">{{ $player->FO_percentage }}</td>
                <td>{{ $player->allowed }}</td>
                <td>{{ $player->saved }}</td>
                <td>{{ $player->save_percentage }}</td>
                @if($admin)
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $player->updated_at)->diffForHumans() }}</td>
                    <td style="display: inline-flex;">
                        <button class="show-modal btn btn-success"
                                data-id="{{$player->id}}"
                                data-name="{{$player->name}}"

                                >
                            <span  class="glyphicon glyphicon-eye-open"></span></button>
                        <button class="edit-modal btn btn-info"
                                data-id="{{$player->id}}"
                                data-name="{{$player->name}}"
                                data-goals="{{$player->goals}}"
                                data-assists="{{$player->assists}}"
                                data-shots="{{$player->shots}}"
                                data-sog="{{$player->sog}}"
                                data-manup="{{$player->manup}}"
                                data-down="{{$player->down}}"
                                data-ground_ball="{{$player->ground_ball}}"
                                data-to="{{$player->TO}}"
                                data-cto="{{$player->CTO}}"
                                data-win="{{$player->win}}"
                                data-lose="{{$player->lose}}"
                                data-allowed="{{$player->allowed}}"
                                data-saved="{{$player->saved}}"
                                data-position="{{$player->position}}"
                                data-number="{{$player->number}}"
                                data-team_id="{{$player->team_id}}"
                                >
                            <span   class="glyphicon glyphicon-edit"></span></button>
                        <button class="delete-modal btn btn-danger" data-id="{{$player->id}}" data-name="{{$player->name}}">
                            <span   class="glyphicon glyphicon-trash"></span></button>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</div><!-- /.col-md-8 -->

<!-- Modal form to add a post -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-name"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name_add" autofocus>
                            <small>Min: 2, Max: 32, only text</small>
                            <p class="errorName text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="content">Team:</label>
                        <div class="col-sm-10">
                            {{--<input class="form-control"  cols="40" rows="5" type="number">--}}
                            <select class="form-control" id="team_id_add">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <p class="errorTeamID text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Number:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="number_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Position:</label>
                        <div class="col-sm-10">
                            <input type="text" min="0" class="form-control" id="position_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Goals:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="goals_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Assists:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="assists_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Shots:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="shots_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">SOG:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="sog_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Manup:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="manup_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Down:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="down_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Ground Ball:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="ground_ball_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">TO:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="TO_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">CTO:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="CTO_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Win:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="win_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Lose:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="lose_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Allowed:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="allowed_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Saved:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="saved_add" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success add" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-check'></span> Add
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal form to show a post -->
<div id="showModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-name"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_show" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="name_show" disabled>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal form to edit a form -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-name"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_edit" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name_edit" autofocus>
                            <p class="errorName text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="content">Team:</label>
                        <div class="col-sm-10">
                            {{--<input class="form-control"  cols="40" rows="5" type="number">--}}
                            <select class="form-control" id="team_id_edit">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <p class="errorTeamID text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Number:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="number_edit" autofocus>
                            <p class="errorName text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Position:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="position_edit" autofocus>
                            <p class="errorName text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Goals:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="goals_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Assists:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="assists_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Shots:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="shots_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">SOG:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="sog_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Manup:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="manup_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Down:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="down_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Ground Ball:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="ground_ball_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">TO:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="TO_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">CTO:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="CTO_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Win:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="win_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Lose:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="lose_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Allowed:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="allowed_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Saved:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" value="0" class="form-control" id="saved_edit" >
                            <small>Only numbers greater than 0. </small>
                            <p class="errorGoals text-center alert alert-danger hidden"></p>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                        <span class='glyphicon glyphicon-check'></span> Edit
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal form to delete a form -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-name"></h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Are you sure you want to delete the following post?</h3>
                <br />
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_delete" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="name_delete" disabled>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-trash'></span> Delete
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
{{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

<!-- Bootstrap JavaScript -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

<!-- toastr notifications -->
{{-- <script type="text/javascript" src="{{ asset('toastr/toastr.min.js') }}"></script> --}}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- icheck checkboxes -->
<script type="text/javascript" src="{{ asset('icheck/icheck.min.js') }}"></script>

<!-- Delay table load until everything else is loaded -->
<script>
    $(window).load(function(){
        $('#postTable').removeAttr('style');
    })
</script>

<script>
    $(document).ready(function(){
        $('.published').iCheck({
            checkboxClass: 'icheckbox_square-yellow',
            radioClass: 'iradio_square-yellow',
            increaseArea: '20%'
        });
        $('.published').on('ifClicked', function(event){
            id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('changeStatus') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id
                },
                success: function(data) {
                    // empty
                }
            });
        });
        $('.published').on('ifToggled', function(event) {
            $(this).closest('tr').toggleClass('warning');
        });
    });

</script>

<!-- AJAX CRUD operations -->
<script type="text/javascript">
    // add a new post
    $(document).on('click', '.add-modal', function() {
        $('.modal-name').text('Add');
        $('#addModal').modal('show');
    });
    $('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'POST',
            url: 'players',
            data: {
                '_token': $('input[name=_token]').val(),
                'name': $('#name_add').val(),
                'goals': $('#goals_add').val(),
                'assists': $('#assists_add').val(),
                'shots': $('#shots_add').val(),
                'sog': $('#sog_add').val(),
                'manup': $('#manup_add').val(),
                'down': $('#down_add').val(),
                'ground_ball': $('#ground_ball_add').val(),
                'TO': $('#TO_add').val(),
                'CTO': $('#CTO_add').val(),
                'win': $('#win_add').val(),
                'lose': $('#lose_add').val(),
                'allowed': $('#allowed_add').val(),
                'saved': $('#saved_add').val(),
                'team_id': $('#team_id_add').val(),
                'position': $('#position_add').val(),
                'number': $('#number_add').val()
            },
            success: function(data) {
                $('.errorName').addClass('hidden');
                $('.errorContent').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#addModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }
                    if (data.errors.content) {
                        $('.errorContent').removeClass('hidden');
                        $('.errorContent').text(data.errors.content);
                    }
                } else {
                    toastr.success('Successfully added Team!', 'Success Alert', {timeOut: 5000});
                    $('#postTable').prepend("<tr class='item" + data.id + "'>" +
                    "<td class='col1'>" + data.id + "</td>" +
                    "<td>" + data.name + "</td>" +
                    "<td>" + data.team_name + "</td>" +
                    "<td>" + data.number + "</td>" +
                    "<td>" + data.position + "</td>" +
                    "<td>" + data.goals + "</td>" +
                    "<td>" + data.assists + "</td>" +
                    "<td>" + data.points + "</td>" +
                    "<td>" + data.shots + "</td>" +
                    "<td>" + data.shots_percentage + "</td>" +
                    "<td>" + data.sog + "</td>" +
                    "<td>" + data.sog_percentage + "</td>" +
                    "<td>" + data.manup + "</td>" +
                    "<td>" + data.down + "</td>" +
                    "<td>" + data.ground_ball + "</td>" +
                    "<td>" + data.TO + "</td>" +
                    "<td>" + data.CTO + "</td>" +
                    "<td>" + data.win + "</td>" +
                    "<td>" + data.lose + "</td>" +
                    "<td>" + data.FO_percentage + "</td>" +
                    "<td>" + data.allowed + "</td>" +
                    "<td>" + data.saved + "</td>" +
                    "<td>" + data.save_percentage + "</td>" +


                    "<td>Just now!</td>" +
                    "<td><button class='show-modal btn btn-success' data-id='" + data.id +
                    "' data-name='" + data.name +
                    "' data-goals='" + data.goals +
                    "' data-assists='" + data.assists +
                    "' data-shots='" + data.shots +
                    "' data-sog='" + data.sog +
                    "' data-ground_ball='" + data.ground_ball +
                    "' data-manup='" + data.manup +
                    "' data-down='" + data.down +
                    "' data-to='" + data.TO +
                    "' data-cto='" + data.CTO +
                    "' data-win='" + data.win +
                    "' data-lose='" + data.lose +
                    "' data-allowed='" + data.allowed +
                    "' data-position='" + data.position +
                    "' data-team_id='" + data.team_id +
                    "' data-number='" + data.number +
                    "' data-saved='" + data.saved +
                    "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' " +
                    "data-id='" + data.id +
                    "' data-name='" + data.name +
                    "' data-goals='" + data.goals +
                    "' data-assists='" + data.assists +
                    "' data-shots='" + data.shots +
                    "' data-sog='" + data.sog +
                    "' data-ground_ball='" + data.ground_ball +
                    "' data-manup='" + data.manup +
                    "' data-down='" + data.down +
                    "' data-to='" + data.TO +
                    "' data-cto='" + data.CTO +
                    "' data-win='" + data.win +
                    "' data-lose='" + data.lose +
                    "' data-allowed='" + data.allowed +
                    "' data-saved='" + data.saved +
                    "' data-position='" + data.position +
                    "' data-team_id='" + data.team_id +
                    "' data-number='" + data.number +
                    "' data-content='" + data.content + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                    $('.new_published').iCheck({
                        checkboxClass: 'icheckbox_square-yellow',
                        radioClass: 'iradio_square-yellow',
                        increaseArea: '20%'
                    });
                    $('.new_published').on('ifToggled', function(event){
                        $(this).closest('tr').toggleClass('warning');
                    });
                    $('.new_published').on('ifChanged', function(event){
                        id = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ URL::route('changeStatus') }}",
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id': id
                            },
                            success: function(data) {
                                // empty
                            }
                        });
                    });
                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            }
        });
    });

    // Show a post
    $(document).on('click', '.show-modal', function() {
        $('.modal-name').text('Show');
        $('#id_show').val($(this).data('id'));
        $('#name_show').val($(this).data('name'));
        $('#content_show').val($(this).data('content'));
        $('#showModal').modal('show');
    });


    // Edit a post
    $(document).on('click', '.edit-modal', function() {
        $('.modal-name').text('Edit');
        $('#id_edit').val($(this).data('id'));
        $('#name_edit').val($(this).data('name'));
        $('#goals_edit').val($(this).data('goals'));
        $('#assists_edit').val($(this).data('assists'));
        $('#shots_edit').val($(this).data('shots'));
        $('#sog_edit').val($(this).data('sog'));
        $('#manup_edit').val($(this).data('manup'));
        $('#down_edit').val($(this).data('down'));
        $('#ground_ball_edit').val($(this).data('ground_ball'));
        $('#TO_edit').val($(this).data('to'));
        $('#CTO_edit').val($(this).data('cto'));
        $('#win_edit').val($(this).data('win'));
        $('#lose_edit').val($(this).data('lose'));
        $('#allowed_edit').val($(this).data('allowed'));
        $('#saved_edit').val($(this).data('saved'));
        $('#number_edit').val($(this).data('number'));
        $('#team_id_edit').val($(this).data('team_id'));
        $('#position_edit').val($(this).data('position'));
        id = $('#id_edit').val();
        $('#editModal').modal('show');
    });
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'PUT',
            url: 'players/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#id_edit").val(),
                'name': $('#name_edit').val(),
                'goals': $('#goals_edit').val(),
                'assists': $('#assists_edit').val(),
                'shots': $('#shots_edit').val(),
                'sog': $('#sog_edit').val(),
                'manup': $('#manup_edit').val(),
                'down': $('#down_edit').val(),
                'ground_ball': $('#ground_ball_edit').val(),
                'TO': $('#TO_edit').val(),
                'CTO': $('#CTO_edit').val(),
                'win': $('#win_edit').val(),
                'lose': $('#lose_edit').val(),
                'allowed': $('#allowed_edit').val(),
                'saved': $('#saved_edit').val(),
                'team_id': $('#team_id_edit').val(),
                'position': $('#position_edit').val(),
                'number': $('#number_edit').val()
            },
            success: function(data) {
                $('.errorName').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }
                } else {
                    toastr.success('Successfully updated Team!', 'Success Alert', {timeOut: 5000});
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td class='col1'>" + data.id + "</td>" +
                    "<td>" + data.name + "</td>" +
                    "<td>" + data.team_name + "</td>" +
                    "<td>" + data.number + "</td>" +
                    "<td>" + data.position + "</td>" +
                    "<td>" + data.goals + "</td>" +
                    "<td>" + data.assists + "</td>" +
                    "<td>" + data.points + "</td>" +
                    "<td>" + data.shots + "</td>" +
                    "<td>" + data.shots_percentage + "</td>" +
                    "<td>" + data.sog + "</td>" +
                    "<td>" + data.sog_percentage + "</td>" +
                    "<td>" + data.manup + "</td>" +
                    "<td>" + data.down + "</td>" +
                    "<td>" + data.ground_ball + "</td>" +
                    "<td>" + data.TO + "</td>" +
                    "<td>" + data.CTO + "</td>" +
                    "<td>" + data.win + "</td>" +
                    "<td>" + data.lose + "</td>" +
                    "<td>" + data.FO_percentage + "</td>" +
                    "<td>" + data.allowed + "</td>" +
                    "<td>" + data.saved + "</td>" +
                    "<td>" + data.save_percentage + "</td>" +


                    "<td>Right now</td><td><button class='show-modal btn btn-success' " +
                    "data-id='" + data.id +
                    "' data-name='" + data.name +
                    "' data-goals='" + data.goals +
                    "' data-assists='" + data.assists +
                    "' data-shots='" + data.shots +
                    "' data-sog='" + data.sog +
                    "' data-ground_ball='" + data.ground_ball +
                    "' data-manup='" + data.manup +
                    "' data-down='" + data.down +
                    "' data-to='" + data.TO +
                    "' data-cto='" + data.CTO +
                    "' data-win='" + data.win +
                    "' data-lose='" + data.lose +
                    "' data-allowed='" + data.allowed +
                    "' data-saved='" + data.saved +
                    "' data-position='" + data.position +
                    "' data-team_id='" + data.team_id +
                    "' data-number='" + data.number +

                    "' data-content='" + data.content + "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' data-content='" + data.content + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

                    if (data.is_published) {
                        $('.edit_published').prop('checked', true);
                        $('.edit_published').closest('tr').addClass('warning');
                    }
                    $('.edit_published').iCheck({
                        checkboxClass: 'icheckbox_square-yellow',
                        radioClass: 'iradio_square-yellow',
                        increaseArea: '20%'
                    });
                    $('.edit_published').on('ifToggled', function(event) {
                        $(this).closest('tr').toggleClass('warning');
                    });
                    $('.edit_published').on('ifChanged', function(event){
                        id = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ URL::route('changeStatus') }}",
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id': id
                            },
                            success: function(data) {
                                // empty
                            }
                        });
                    });
                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            }
        });
    });

    // delete a post
    $(document).on('click', '.delete-modal', function() {
        $('.modal-name').text('Delete');
        $('#id_delete').val($(this).data('id'));
        $('#name_delete').val($(this).data('name'));
        $('#deleteModal').modal('show');
        id = $('#id_delete').val();
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'DELETE',
            url: 'players/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
            },
            success: function(data) {
                toastr.success('Successfully deleted Team!', 'Success Alert', {timeOut: 5000});
                $('.item' + data['id']).remove();
                $('.col1').each(function (index) {
                    $(this).html(index+1);
                });
            }
        });
    });
</script>

</body>
</html>