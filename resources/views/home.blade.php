@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a href="/teams">Manage Teams</a>
                </div>
                <div class="panel-body">
                    <a href="/players">Manage Players</a>
                </div>
                <div class="panel-body">
                    <a href="/games">Manage Games</a>
                </div>
                <div class="panel-body">
                    <a href="/gamelogs">Manage Game Logs</a>
                </div>
                <div class="panel-body">
                    <a href="/gamerecords">Manage Game Records</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
