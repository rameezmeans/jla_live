<?php namespace App\Http\Controllers;

use App\GameLogs;
use App\GameRecords;
use App\Player;
use App\Team;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Game;
use View;


class GameRecordsController extends Controller
{
    /**
    * @var array
    */
    protected $rules = [];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gamerecords = GameRecords::orderBy('id', 'desc')->get();
        $games = Game::orderBy('id', 'desc')->get();
        $teams = Team::orderBy('id', 'desc')->get();
        $opponents = Team::orderBy('id', 'desc')->get();
        $players = Player::orderBy('id', 'desc')->get();

        $admin = false;

        if($user = Auth::user())
        {
            if($user->id == 1){
                $admin = true;
            }
        }


        return view('gamerecords.gamerecords', ['admin' => $admin, 'gamerecords' => $gamerecords, 'games' => $games, 'teams' => $teams, 'opponents' => $opponents, 'players' => $players]);
    }

    public function showGameRecord($id){

        $gamelog = GameLogs::findOrFail($id);

        $gamerecords = GameRecords::orderBy('id', 'desc')->get();


        $players = Player::where('team_id', $gamelog->team_id)->orWhere('team_id', $gamelog->opponent_id)->get();

//        dd($players);

        if($user = Auth::user())
        {
            if($user->id == 1){
                $admin = true;
            }
        }

        return view('gamerecords.gamerecord', ['gamerecords' => $gamerecords, 'admin' => $admin, 'players' => $players, 'gamelog' => $gamelog]);


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//            dd($request->all());

            $gamerecord = new GameRecords();
            $gamerecord->player_id = $request->player_id;

            $gamerecord->team_id = Player::FindOrFail($request->player_id)->team_id;
            $gamerecord->position = Player::FindOrFail($request->player_id)->position;


            $gamerecord->number = Player::FindOrFail($request->player_id)->number;

            $team_id = Player::FindOrFail($request->player_id)->team_id;

//        dd( $gamerecord->position );



            $gamerecord->gamelog_id = $request->gamelog_id;

            $gamelog = GameLogs::findOrFail( $request->gamelog_id );



            if($team_id == $gamelog->team_id){
                $gamerecord->home = 1;
            }
            else if($team_id == $gamelog->opponent_id){
                $gamerecord->home = 0;
            }

            $gamerecord->minutes = $request->minutes;

            if($request->starter == 'on')
                $gamerecord->starter = 1;
            else
                $gamerecord->starter = 0;





            $gamerecord->goals = $request->all()['goals'];
            $gamerecord->assists = $request->all()['assists'];
            $gamerecord->shots = $request->all()['shots'];
            $gamerecord->sog = $request->all()['sog'];
            $gamerecord->manup = $request->all()['manup'];
            $gamerecord->down = $request->all()['down'];
            $gamerecord->ground_ball = $request->all()['ground_ball'];
            $gamerecord->TO = $request->all()['TO'];
            $gamerecord->CTO = $request->all()['CTO'];
            $gamerecord->win = $request->all()['win'];
            $gamerecord->lose = $request->all()['lose'];
            $gamerecord->allowed = $request->all()['allowed'];
            $gamerecord->saved = $request->all()['saved'];

            $gamerecord->points = $gamerecord['goals'] + $gamerecord['assists'];

            if($gamerecord['shots'] != 0)
                $gamerecord->shots_percentage = ($gamerecord['goals'] / $gamerecord['shots']) * 100;
            else
                $gamerecord->shots_percentage = 0;

            if($gamerecord['shots'] != 0)
                $gamerecord->sog_percentage = ($gamerecord['sog'] / $gamerecord['shots']) * 100;
            else
                $gamerecord->sog_percentage = 0;

            if($gamerecord['win'] + $gamerecord['lose'] != 0)
                $gamerecord->FO_percentage = ($gamerecord['win'] / ( $gamerecord['win'] + $gamerecord['lose'] )) * 100;
            else
                $gamerecord->FO_percentage = 0;

            if($gamerecord['allowed'] + $gamerecord['saved'] )
                $gamerecord->save_percentage = ($gamerecord['saved'] / ( $gamerecord['allowed'] + $gamerecord['saved'] )) * 100;
            else
                $gamerecord->save_percentage = 0;

//        dd($gamerecord);


            $gamerecord->save();

            $gamerecord->player_name = Player::findOrFail($request->player_id)->name;
            $gamerecord->team_name = Team::findOrFail($team_id)->name;


            return response()->json($gamerecord);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gamerecords = GameRecords::findOrFail($id);

        return view('team.show', ['team' => $gamerecords]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gamerecord = new GameRecords();
        $gamerecord->player_id = $request->player_id;

        $gamerecord->team_id = Player::FindOrFail($request->player_id)->team_id;
        $gamerecord->position = Player::FindOrFail($request->player_id)->position;


        $gamerecord->number = Player::FindOrFail($request->player_id)->number;

        $team_id = Player::FindOrFail($request->player_id)->team_id;

//        dd( $gamerecord->position );



        $gamerecord->gamelog_id = $request->gamelog_id;

        $gamelog = GameLogs::findOrFail( $request->gamelog_id );



        if($team_id == $gamelog->team_id){
            $gamerecord->home = 1;
        }
        else if($team_id == $gamelog->opponent_id){
            $gamerecord->home = 0;
        }

        $gamerecord->minutes = $request->minutes;

        if($request->starter == 'on')
            $gamerecord->starter = 1;
        else
            $gamerecord->starter = 0;





        $gamerecord->goals = $request->all()['goals'];
        $gamerecord->assists = $request->all()['assists'];
        $gamerecord->shots = $request->all()['shots'];
        $gamerecord->sog = $request->all()['sog'];
        $gamerecord->manup = $request->all()['manup'];
        $gamerecord->down = $request->all()['down'];
        $gamerecord->ground_ball = $request->all()['ground_ball'];
        $gamerecord->TO = $request->all()['TO'];
        $gamerecord->CTO = $request->all()['CTO'];
        $gamerecord->win = $request->all()['win'];
        $gamerecord->lose = $request->all()['lose'];
        $gamerecord->allowed = $request->all()['allowed'];
        $gamerecord->saved = $request->all()['saved'];

        $gamerecord->points = $gamerecord['goals'] + $gamerecord['assists'];

        if($gamerecord['shots'] != 0)
            $gamerecord->shots_percentage = ($gamerecord['goals'] / $gamerecord['shots']) * 100;
        else
            $gamerecord->shots_percentage = 0;

        if($gamerecord['shots'] != 0)
            $gamerecord->sog_percentage = ($gamerecord['sog'] / $gamerecord['shots']) * 100;
        else
            $gamerecord->sog_percentage = 0;

        if($gamerecord['win'] + $gamerecord['lose'] != 0)
            $gamerecord->FO_percentage = ($gamerecord['win'] / ( $gamerecord['win'] + $gamerecord['lose'] )) * 100;
        else
            $gamerecord->FO_percentage = 0;

        if($gamerecord['allowed'] + $gamerecord['saved'] )
            $gamerecord->save_percentage = ($gamerecord['saved'] / ( $gamerecord['allowed'] + $gamerecord['saved'] )) * 100;
        else
            $gamerecord->save_percentage = 0;

//        dd($gamerecord);


        $gamerecord->save();

        $gamerecord->player_name = Player::findOrFail($request->player_id)->name;
        $gamerecord->team_name = Team::findOrFail($team_id)->name;


        return response()->json($gamerecord);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gamerecord = GameRecords::findOrFail($id);
        $gamerecord->delete();

        return response()->json($gamerecord);
    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $gamerecord = GameRecords::findOrFail($id);
        $gamerecord->is_published = !$gamerecord->is_published;
        $gamerecord->save();

        return response()->json($gamerecord);
    }
}