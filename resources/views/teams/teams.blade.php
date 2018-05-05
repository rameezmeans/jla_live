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

    <title>Manage Teams</title>
    
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
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Teams</h2>
            </div>
        </div>
        @if($admin)
        <div class="row">
            <div class="col-md-12 text-center"><a href="#" class="add-modal">Add a Team</a></div>
        </div>
        @endif
        <br />

        

                    <table class="table table-striped table-hover" id="postTable" style="visibility: hidden;">
                        <thead>
                        <tr>
                            <th class="end"></th>
                            <th class="end">Team</th>

                            @if($admin)
                                <th> </th>
                                <th> </th>
                            @endif
                            </tr>
                        <tr>
                            <th class="end">#</th>
                            <th class="end">Name</th>

                                @if($admin)
                                    <th>Last updated</th>
                                    <th>Actions</th>
                                @endif
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            @foreach($teams as $indexKey => $team)
                                <tr class="item{{$team->id}} @if($team->is_published) warning @endif">
                                    <td class="col1">{{ $indexKey+1 }}</td>
                                    <td><a href="{{ URL('').'/team/'.$team->id }}">{{$team->name}}</a></td>

                                    @if($admin)
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $team->updated_at)->diffForHumans() }}</td>
                                        <td style="display: inline-flex;">
                                            <button class="show-modal btn btn-success"
                                                    data-id="{{$team->id}}"
                                                    data-name="{{$team->name}}"

                                                    >
                                            <span  class="glyphicon glyphicon-eye-open"></span></button>
                                            <button class="edit-modal btn btn-info"
                                                    data-id="{{$team->id}}"
                                                    data-name="{{$team->name}}"
                                                    data-goals="{{$team->goals}}"
                                                    data-assists="{{$team->assists}}"
                                                    data-shots="{{$team->shots}}"
                                                    data-sog="{{$team->sog}}"
                                                    data-manup="{{$team->manup}}"
                                                    data-down="{{$team->down}}"
                                                    data-ground_ball="{{$team->ground_ball}}"
                                                    data-to="{{$team->TO}}"
                                                    data-cto="{{$team->CTO}}"
                                                    data-win="{{$team->win}}"
                                                    data-lose="{{$team->lose}}"
                                                    data-allowed="{{$team->allowed}}"
                                                    data-saved="{{$team->saved}}"
                                                    >
                                            <span   class="glyphicon glyphicon-edit"></span></button>
                                            <button class="delete-modal btn btn-danger" data-id="{{$team->id}}" data-name="{{$team->name}}">
                                            <span   class="glyphicon glyphicon-trash"></span></button>
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
                url: 'teams',
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
                    'saved': $('#saved_add').val()
                },
                success: function(data) {
                    location.reload();

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
            id = $('#id_edit').val();
            $('#editModal').modal('show');
        });
        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'PUT',
                url: 'teams/' + id,
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
                    'saved': $('#saved_edit').val()
                },
                success: function(data) {
                    location.reload();

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
                url: 'teams/' + id,
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