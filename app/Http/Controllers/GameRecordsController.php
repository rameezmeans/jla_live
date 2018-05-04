<?php namespace App\Http\Controllers;

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
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $gamerecord = new GameRecords();
            $gamerecord->gp = $request->gp;
            $gamerecord->gb = $request->gb;
            $gamerecord->shots = $request->shots;
            $gamerecord->spct = $request->spct;
            $gamerecord->sog = $request->sog;
            $gamerecord->sogpct = $request->sogpct;
            $gamerecord->fo = $request->fo;
            $gamerecord->fopct = $request->fopct;
            $gamerecord->player_id = $request->player_id;
            $gamerecord->game_id = $request->game_id;
            $gamerecord->team_id = $request->team_id;
            $gamerecord->opponent_id = $request->opponent_id;
            $gamerecord->save();

            $gamerecord->player_name = Player::findOrFail($request->player_id)->name;
            $gamerecord->team_name = Team::findOrFail($request->team_id)->name;
            $gamerecord->game_name = Game::findOrFail($request->game_id)->name;
            $gamerecord->opponent_name = Team::findOrFail($request->opponent_id)->name;


            return response()->json($gamerecord);
        }
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
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $gamerecord = GameRecords::findOrFail($id);
            $gamerecord->gp = $request->gp;
            $gamerecord->gb = $request->gb;
            $gamerecord->shots = $request->shots;
            $gamerecord->spct = $request->spct;
            $gamerecord->sog = $request->sog;
            $gamerecord->sogpct = $request->sogpct;
            $gamerecord->fo = $request->fo;
            $gamerecord->fopct = $request->fopct;
            $gamerecord->player_id = $request->player_id;
            $gamerecord->game_id = $request->game_id;
            $gamerecord->team_id = $request->team_id;
            $gamerecord->opponent_id = $request->opponent_id;
            $gamerecord->save();

            $gamerecord->player_name = Player::findOrFail($request->player_id)->name;
            $gamerecord->team_name = Team::findOrFail($request->team_id)->name;
            $gamerecord->game_name = Game::findOrFail($request->game_id)->name;
            $gamerecord->opponent_name = Team::findOrFail($request->opponent_id)->name;

            return response()->json($gamerecord);
        }
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