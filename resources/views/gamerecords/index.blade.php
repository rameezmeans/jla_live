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

    <title>Manage Game Records</title>
    
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
                <h2 class="text-center">Game Records</h2>
            </div>
            @if($admin)
            <div class="row">
                <div class="col-md-12 text-center"><a href="#" class="add-modal">Add a Game Record</a></div>
            </div>
            @endif
        </div>
        <br />

                    <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
                        <thead>
                            <tr>
                                <th valign="middle">#</th>
                                <th>gp</th>
                                <th>gb</th>
                                <th>shots</th>
                                <th>spct</th>
                                <th>sog</th>
                                <th>sogpct</th>
                                <th>fo</th>
                                <th>fopct</th>
                                <th>Player</th>
                                <th>Game</th>
                                <th>Team</th>
                                <th>Opponent</th>
                                @if($admin)
                                <th>Last updated</th>
                                <th>Actions</th>
                                @endif
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            @foreach($gamerecords as $indexKey => $gamerecord)
                                <tr class="item{{$gamerecord->id}} @if($gamerecord->is_published) warning @endif">
                                    <td class="col1">{{ $indexKey+1 }}</td>
                                    <td class="col1">{{ $gamerecord->gp }}</td>
                                    <td class="col1">{{ $gamerecord->gb }}</td>
                                    <td class="col1">{{ $gamerecord->shots }}</td>
                                    <td class="col1">{{ $gamerecord->spct }}</td>
                                    <td class="col1">{{ $gamerecord->sog }}</td>
                                    <td class="col1">{{ $gamerecord->sogpct }}</td>
                                    <td class="col1">{{ $gamerecord->fo }}</td>
                                    <td class="col1">{{ $gamerecord->fopct }}</td>
                                    <td>
                                        {{\App\Player::findOrFail($gamerecord->player_id)->name}}
                                    </td>
                                    <td>
                                        {{\App\Game::findOrFail($gamerecord->game_id)->name}}
                                    </td>
                                    <td>
                                        {{\App\Team::findOrFail($gamerecord->team_id)->name}}
                                    </td>
                                    <td>
                                        {{\App\Team::findOrFail($gamerecord->opponent_id)->name}}
                                    </td>
                                    @if($admin)
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $gamerecord->updated_at)->diffForHumans() }}</td>
                                    <td>
                                        <button class="show-modal btn btn-success"

                                                data-id="{{$gamerecord->id}}"
                                                data-gb="{{$gamerecord->gb}}"
                                                data-gp="{{$gamerecord->gp}}"
                                                data-shots="{{$gamerecord->shots}}"
                                                data-spct="{{$gamerecord->spct}}"
                                                data-sog="{{$gamerecord->sog}}"
                                                data-sogpct="{{$gamerecord->sogpct}}"
                                                data-fo="{{$gamerecord->fo}}"
                                                data-fopct="{{$gamerecord->fopct}}"
                                                data-player_id="{{$gamerecord->player_id}}"
                                                data-player_name="{{\App\Player::findOrFail($gamerecord->player_id)->name}}"
                                                data-game_id="{{$gamerecord->game_id}}"
                                                data-game_name="{{\App\Game::findOrFail($gamerecord->game_id)->name}}"
                                                data-team_id="{{$gamerecord->team_id}}"
                                                data-team_name="{{\App\Team::findOrFail($gamerecord->team_id)->name}}"
                                                data-opponent_id="{{$gamerecord->opponent_id}}"
                                                data-opponent_name="{{\App\Team::findOrFail($gamerecord->opponent_id)->name}}"

                                                >
                                        <span class="glyphicon glyphicon-eye-open"></span> Show</button>
                                        <button class="edit-modal btn btn-info"

                                                data-id="{{$gamerecord->id}}"
                                                data-gb="{{$gamerecord->gb}}"
                                                data-gp="{{$gamerecord->gp}}"
                                                data-shots="{{$gamerecord->shots}}"
                                                data-spct="{{$gamerecord->spct}}"
                                                data-sog="{{$gamerecord->sog}}"
                                                data-sogpct="{{$gamerecord->sogpct}}"
                                                data-fo="{{$gamerecord->fo}}"
                                                data-fopct="{{$gamerecord->fopct}}"
                                                data-player_id="{{$gamerecord->player_id}}"
                                                data-player_name="{{\App\Player::findOrFail($gamerecord->player_id)->name}}"
                                                data-game_id="{{$gamerecord->game_id}}"
                                                data-game_name="{{\App\Game::findOrFail($gamerecord->game_id)->name}}"
                                                data-team_id="{{$gamerecord->team_id}}"
                                                data-team_name="{{\App\Team::findOrFail($gamerecord->team_id)->name}}"
                                                data-opponent_id="{{$gamerecord->opponent_id}}"
                                                data-opponent_name="{{\App\Team::findOrFail($gamerecord->opponent_id)->name}}"

                                                >
                                        <span class="glyphicon glyphicon-edit"></span> Edit</button>
                                        <button class="delete-modal btn btn-danger"

                                                data-id="{{$gamerecord->id}}"
                                                data-gb="{{$gamerecord->gb}}"
                                                data-gp="{{$gamerecord->gp}}"
                                                data-shots="{{$gamerecord->shots}}"
                                                data-spct="{{$gamerecord->spct}}"
                                                data-sog="{{$gamerecord->sog}}"
                                                data-sogpct="{{$gamerecord->sogpct}}"
                                                data-fo="{{$gamerecord->fo}}"
                                                data-fopct="{{$gamerecord->fopct}}"
                                                data-player_id="{{$gamerecord->player_id}}"
                                                data-player_name="{{\App\Player::findOrFail($gamerecord->player_id)->name}}"
                                                data-game_id="{{$gamerecord->game_id}}"
                                                data-game_name="{{\App\Game::findOrFail($gamerecord->game_id)->name}}"
                                                data-team_id="{{$gamerecord->team_id}}"
                                                data-team_name="{{\App\Team::findOrFail($gamerecord->team_id)->name}}"
                                                data-opponent_id="{{$gamerecord->opponent_id}}"
                                                data-opponent_name="{{\App\Team::findOrFail($gamerecord->opponent_id)->name}}"

                                                >
                                        <span class="glyphicon glyphicon-trash"></span> Delete</button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

    </div><!-- /.col-md-8 -->

    <!-- Modal form to add a post -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">GB:</label>
                            <div class="col-sm-10">
                                <input id="gb_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">GP:</label>
                            <div class="col-sm-10">
                                <input id="gp_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Shots:</label>
                            <div class="col-sm-10">
                                <input id="shots_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">SPCT:</label>
                            <div class="col-sm-10">
                                <input id="spct_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">SOG:</label>
                            <div class="col-sm-10">
                                <input id="sog_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">SOGPCT:</label>
                            <div class="col-sm-10">
                                <input id="sogpct_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">FO:</label>
                            <div class="col-sm-10">
                                <input id="fo_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">FOPCT:</label>
                            <div class="col-sm-10">
                                <input id="fopct_add" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Game:</label>
                            <div class="col-sm-10">
                                {{--<input class="form-control"  cols="40" rows="5" type="number">--}}
                                <select class="form-control" id="game_id_add">
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Player:</label>
                            <div class="col-sm-10">
                                {{--<input class="form-control"  cols="40" rows="5" type="number">--}}
                                <select class="form-control" id="player_id_add">
                                    @foreach($players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
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
                            <label class="control-label col-sm-2" for="content">Opponent:</label>
                            <div class="col-sm-10">
                                {{--<input class="form-control"  cols="40" rows="5" type="number">--}}
                                <select class="form-control" id="opponent_id_add">
                                    @foreach($opponents as $opponent)
                                        <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
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
                    <h4 class="modal-title"></h4>
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
                            <label class="control-label col-sm-2" for="id">GB:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="gb_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">GP:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="gp_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">Shots:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="shots_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">SPCT:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="spct_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">SOG:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="sog_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">SOGPCT:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="sogpct_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">FO:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fo_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">FOPCT:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fopct_show" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Player:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="player_name_show" cols="40" rows="5" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Game:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="game_name_show" cols="40" rows="5" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Team:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="team_name_show" cols="40" rows="5" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Opponent:</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="opponent_name_show" cols="40" rows="5" disabled>
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
                    <h4 class="modal-title"></h4>
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
                            <label class="control-label col-sm-2" for="content">GB:</label>
                            <div class="col-sm-10">
                                <input id="gb_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">GP:</label>
                            <div class="col-sm-10">
                                <input id="gp_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Shots:</label>
                            <div class="col-sm-10">
                                <input id="shots_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">SPCT:</label>
                            <div class="col-sm-10">
                                <input id="spct_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">SOG:</label>
                            <div class="col-sm-10">
                                <input id="sog_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">SOGPCT:</label>
                            <div class="col-sm-10">
                                <input id="sogpct_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">FO:</label>
                            <div class="col-sm-10">
                                <input id="fo_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">FOPCT:</label>
                            <div class="col-sm-10">
                                <input id="fopct_edit" class="form-control"  cols="40" rows="5" type="number" min="0" value="1">
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Player:</label>
                            <div class="col-sm-10">
                                {{--<textarea class="form-control" id="game_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="player_id_edit" cols="40" rows="5">
                                    @foreach($players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Game:</label>
                            <div class="col-sm-10">
                                {{--<textarea class="form-control" id="game_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="game_id_edit" cols="40" rows="5">
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Team:</label>
                            <div class="col-sm-10">
                                {{--<textarea class="form-control" id="game_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="team_id_edit" cols="40" rows="5">
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Opponent:</label>
                            <div class="col-sm-10">
                                {{--<textarea class="form-control" id="game_id_edit" cols="40" rows="5"></textarea>--}}
                                <select class="form-control" id="opponent_id_edit" cols="40" rows="5">
                                    @foreach($opponents as $opponent)
                                        <option value="{{ $opponent->id }}">{{ $opponent->name }}</option>
                                    @endforeach
                                </select>
                                <p class="errorTeamID text-center alert alert-danger hidden"></p>
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
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete the following Game Record?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_delete" disabled>
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

        });
        
    </script>

    <!-- AJAX CRUD operations -->
    <script type="text/javascript">
        // add a new post
        $(document).on('click', '.add-modal', function() {
            $('.modal-title').text('Add');
            $('#addModal').modal('show');
        });
        $('.modal-footer').on('click', '.add', function() {
            $.ajax({
                type: 'POST',
                url: 'gamerecords',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'gb': $('#gb_add').val(),
                    'gp': $('#gp_add').val(),
                    'shots': $('#shots_add').val(),
                    'spct': $('#spct_add').val(),
                    'sog': $('#sog_add').val(),
                    'sogpct': $('#sogpct_add').val(),
                    'fo': $('#fo_add').val(),
                    'fopct': $('#fopct_add').val(),
                    'player_id': $('#player_id_add').val(),
                    'game_id': $('#game_id_add').val(),
                    'team_id': $('#team_id_add').val(),
                    'opponent_id': $('#opponent_id_add').val()
                },
                success: function(data) {
                    $('.errorName').addClass('hidden');
                    $('.errorTeamID').addClass('hidden');

                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.name) {
                            $('.errorName').removeClass('hidden');
                            $('.errorName').text(data.errors.name);
                        }
                        if (data.errors.game_id) {
                            $('.errorTeamID').removeClass('hidden');
                            $('.errorTeamID').text(data.errors.game_id);
                        }
                    } else {
                        toastr.success('Successfully added Game Record!', 'Success Alert', {timeOut: 5000});
                        $('#postTable').prepend("<tr class='item"

                        + data.id + "'>" +
                        "<td class='col1'>" + data.id + "</td>"
                        + "<td>" +  data.gp + "</td>"
                        + "<td>" +  data.gb + "</td>"
                        + "<td>" +  data.shots + "</td>"
                        + "<td>" +  data.spct + "</td>"
                        + "<td>" +  data.sog + "</td>"
                        + "<td>" +  data.sogpct + "</td>"
                        + "<td>" +  data.fo + "</td>"
                        + "<td>" +  data.fopct + "</td>"
                        + "<td>" +  data.player_name + "</td>"
                        + "<td>" +  data.game_name + "</td>"
                        + "<td>" + data.team_name + "</td>"
                        + "<td>" + data.opponent_name + "</td>"

                        + "<td>Just now!</td><td><button class='show-modal btn btn-success' "

                        + " data-id='" + data.id
                        + "' data-gb='" + data.gb
                        + "' data-gp='" + data.gp
                        + "' data-shots='" + data.shots
                        + "' data-spct='" + data.spct
                        + "' data-sog='" + data.sog
                        + "' data-sogpct='" + data.sogpct
                        + "' data-fopct='" + data.fopct
                        + "' data-fo='" + data.fo
                        + "' data-player_id='" + data.player_id + "' data-player_name='" + data.player_name
                        + "' data-game_id='" + data.game_id +"' data-game_name='" + data.game_name
                        + "' data-team_id='" + data.team_id +"' data-team_name='" + data.team_name
                        + "' data-opponent_id='" + data.opponent_id +"' data-opponent_name='" + data.opponent_name

                        + "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info'"
                        + " data-id='" + data.id
                        + "' data-gb='" + data.gb
                        + "' data-gp='" + data.gp
                        + "' data-shots='" + data.shots
                        + "' data-spct='" + data.spct
                        + "' data-sog='" + data.sog
                        + "' data-sogpct='" + data.sogpct
                        + "' data-fopct='" + data.fopct
                        + "' data-fo='" + data.fo
                        + "' data-player_id='" + data.player_id + "' data-player_name='" + data.player_name
                        + "' data-game_id='" + data.game_id +"' data-game_name='" + data.game_name
                        + "' data-team_id='" + data.team_id +"' data-team_name='" + data.team_name
                        + "' data-opponent_id='" + data.opponent_id +"' data-opponent_name='" + data.opponent_name
                        + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' " +
                        "data-id='" + data.id
                        + " data-id='" + data.id
                        + "' data-gb='" + data.gb
                        + "' data-gp='" + data.gp
                        + "' data-shots='" + data.shots
                        + "' data-spct='" + data.spct
                        + "' data-sog='" + data.sog
                        + "' data-sogpct='" + data.sogpct
                        + "' data-fopct='" + data.fopct
                        + "' data-fo='" + data.fo
                        + "' data-player_id='" + data.player_id + "' data-player_name='" + data.player_name
                        + "' data-game_id='" + data.game_id +"' data-game_name='" + data.game_name
                        + "' data-team_id='" + data.team_id +"' data-team_name='" + data.team_name
                        + "' data-opponent_id='" + data.opponent_id +"' data-opponent_name='" + data.opponent_name

                        + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                        $('.new_published').iCheck({
                            checkboxClass: 'icheckbox_square-yellow',
                            radioClass: 'iradio_square-yellow',
                            increaseArea: '20%'
                        });
                        $('.new_published').on('ifToggled', function(event){
                            $(this).closest('tr').toggleClass('warning');
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
            $('.modal-title').text('Show');
            $('#id_show').val($(this).data('id'));
            $('#gb_show').val($(this).data('gb'));
            $('#gp_show').val($(this).data('gp'));
            $('#shots_show').val($(this).data('shots'));
            $('#spct_show').val($(this).data('spct'));
            $('#sog_show').val($(this).data('sog'));
            $('#sogpct_show').val($(this).data('sogpct'));
            $('#fo_show').val($(this).data('fo'));
            $('#fopct_show').val($(this).data('fopct'));
            $('#game_name_show').val($(this).data('game_name'));
            $('#player_name_show').val($(this).data('player_name'));
            $('#team_name_show').val($(this).data('team_name'));
            $('#opponent_name_show').val($(this).data('opponent_name'));
            $('#showModal').modal('show');
        });


        // Edit a post
        $(document).on('click', '.edit-modal', function() {
            $('.modal-title').text('Edit');
            $('#id_edit').val($(this).data('id'));
            $('#game_id_edit').val($(this).data('game_id'));
            $('#game_name_edit').val($(this).data('game_name'));
            $('#player_id_edit').val($(this).data('player_id'));
            $('#player_name_edit').val($(this).data('player_name'));
            $('#team_id_edit').val($(this).data('team_id'));
            $('#team_name_edit').val($(this).data('team_name'))
            ;$('#opponent_id_edit').val($(this).data('opponent_id'));
            $('#opponent_name_edit').val($(this).data('opponent_name'));
            id = $('#id_edit').val();
            $('#editModal').modal('show');
        });
        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'PUT',
                url: 'gamerecords/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#id_edit").val(),
                    'gb': $('#gb_edit').val(),
                    'gp': $('#gp_edit').val(),
                    'shots': $('#shots_edit').val(),
                    'spct': $('#spct_edit').val(),
                    'sog': $('#sog_edit').val(),
                    'sogpct': $('#sogpct_edit').val(),
                    'fo': $('#fo_edit').val(),
                    'fopct': $('#fopct_edit').val(),
                    'player_id': $('#player_id_edit').val(),
                    'game_id': $('#game_id_edit').val(),
                    'team_id': $('#team_id_edit').val(),
                    'opponent_id': $('#opponent_id_edit').val()
                },
                success: function(data) {
                    $('.errorName').addClass('hidden');
                    $('.errorTeamID').addClass('hidden');

                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#editModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.name) {
                            $('.errorName').removeClass('hidden');
                            $('.errorName').text(data.errors.name);
                        }
                        if (data.errors.game_id) {
                            $('.errorTeamID').removeClass('hidden');
                            $('.errorTeamID').text(data.errors.game_id);
                        }
                    } else {
                        toastr.success('Successfully updated Game Record!', 'Success Alert', {timeOut: 5000});
                        $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'>"

                        + "<td class='col1'>" + data.id + "</td>"
                        + "<td class='gp'>" +  data.gp + "</td>"
                        + "<td>" +  data.gb + "</td>"
                        + "<td>" +  data.shots + "</td>"
                        + "<td>" +  data.spct + "</td>"
                        + "<td>" +  data.sog + "</td>"
                        + "<td>" +  data.sogpct + "</td>"
                        + "<td>" +  data.fo + "</td>"
                        + "<td>" +  data.fopct + "</td>"
                        + "<td>" +  data.player_name + "</td>"
                        + "<td>" +  data.game_name + "</td>"
                        + "<td>" + data.team_name + "</td>"
                        + "<td>" + data.opponent_name + "</td>"

                        +"<td>Right now</td><td><button class='show-modal btn btn-success' " +
                        "data-id='" + data.id
                        + "' data-gb='" + data.gb
                        + "' data-gp='" + data.gp
                        + "' data-shots='" + data.shots
                        + "' data-spct='" + data.spct
                        + "' data-sog='" + data.sog
                        + "' data-sogpct='" + data.sogpct
                        + "' data-fopct='" + data.fopct
                        + "' data-fo='" + data.fo
                        + "' data-player_id='" + data.player_id + "' data-player_name='" + data.player_name
                        + "' data-game_id='" + data.game_id +"' data-game_name='" + data.game_name
                        + "' data-team_id='" + data.team_id +"' data-team_name='" + data.team_name
                        + "' data-opponent_id='" + data.opponent_id +"' data-opponent_name='" + data.opponent_name

                        + "'><span class='glyphicon glyphicon-eye-open'></span> Show</button> " +
                        "<button class='edit-modal btn btn-info' " +

                        "data-id='" + data.id
                        + "' data-gb='" + data.gb
                        + "' data-gp='" + data.gp
                        + "' data-shots='" + data.shots
                        + "' data-spct='" + data.spct
                        + "' data-sog='" + data.sog
                        + "' data-sogpct='" + data.sogpct
                        + "' data-fopct='" + data.fopct
                        + "' data-fo='" + data.fo
                        + "' data-player_id='" + data.player_id + "' data-player_name='" + data.player_name
                        + "' data-game_id='" + data.game_id +"' data-game_name='" + data.game_name
                        + "' data-team_id='" + data.team_id +"' data-team_name='" + data.team_name
                        + "' data-opponent_id='" + data.opponent_id +"' data-opponent_name='" + data.opponent_name
                        + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> " +
                        "" +
                        "<button class='delete-modal btn btn-danger' " +
                        "data-id='" + data.id
                        + "' data-game_id='" + data.game_id + "' data-game_name='" + data.game_name

                        + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

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
            $('.modal-title').text('Delete');
            $('#id_delete').val($(this).data('id'));
            $('#name_delete').val($(this).data('name'));
            $('#deleteModal').modal('show');
            id = $('#id_delete').val();
        });
        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'DELETE',
                url: 'gamerecords/' + id,
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    toastr.success('Successfully deleted Game Record!', 'Success Alert', {timeOut: 5000});
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