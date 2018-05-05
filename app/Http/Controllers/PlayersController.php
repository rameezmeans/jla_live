<?php namespace App\Http\Controllers;

use App\GameRecords;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Player;
use App\Team;
use View;


class PlayersController extends Controller
{
    /**
    * @var array
    */
    protected $rules =
    [
        'name' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd();


        $players = Player::orderBy('id', 'desc')->get();
        $teams = Team::orderBy('id', 'desc')->get();

        $admin = false;

        if($user = Auth::user())
        {
            if($user->id == 1){
                $admin = true;
            }
        }


        return view('players.players', ['players' => $players, 'teams' => $teams, 'admin' => $admin]);
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
            $player = new Player();
            $player->name = $request->name;
            $player->team_id = $request->team_id;
            $player->number = $request->number;
            $player->position = $request->position;





            $player->save();

            $player->team_name = Team::findOrFail($request->team_id)->name;

//            dd($player);

            return response()->json($player);
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
        $player = Player::findOrFail($id);


        return view('player.show', ['player' => $player]);
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
            $player = Player::findOrFail($id);
            $player->name = $request->name;
            $player->team_id = $request->team_id;
            $player->number = $request->number;
            $player->position = $request->position;

            $player->save();
            $player->team_name = Team::findOrFail($request->team_id)->name;
            return response()->json($player);
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
        $player = Player::findOrFail($id);
        $player->delete();

        return response()->json($player);
    }

    public function showPlayer($id){

        $player = Player::findOrFail($id);
//        dd($player);

        $player->goals = GameRecords::where('team_id', $id)->sum('goals');
        $player->assists = GameRecords::where('team_id', $id)->sum('assists');
        $player->shots = GameRecords::where('team_id', $id)->sum('shots');
        $player->sog = GameRecords::where('team_id', $id)->sum('sog');
        $player->manup = GameRecords::where('team_id', $id)->sum('manup');
        $player->down = GameRecords::where('team_id', $id)->sum('down');
        $player->ground_ball = GameRecords::where('team_id', $id)->sum('ground_ball');
        $player->TO = GameRecords::where('team_id', $id)->sum('TO');
        $player->CTO = GameRecords::where('team_id', $id)->sum('CTO');
        $player->win = GameRecords::where('team_id', $id)->sum('win');
        $player->lose = GameRecords::where('team_id', $id)->sum('lose');
        $player->allowed = GameRecords::where('team_id', $id)->sum('allowed');
        $player->saved = GameRecords::where('team_id', $id)->sum('saved');

        $player->points = $player['goals'] + $player['assists'];

        if($player['shots'] != 0)
            $player->shots_percentage = ($player['goals'] / $player['shots']) * 100;
        else
            $player->shots_percentage = 0;

        if($player['shots'] != 0)
            $player->sog_percentage = ($player['sog'] / $player['shots']) * 100;
        else
            $player->sog_percentage = 0;

        if($player['win'] + $player['lose'] != 0)
            $player->FO_percentage = ($player['win'] / ( $player['win'] + $player['lose'] )) * 100;
        else
            $player->FO_percentage = 0;

        if($player['allowed'] + $player['saved'] )
            $player->save_percentage = ($player['saved'] / ( $player['allowed'] + $player['saved'] )) * 100;
        else
            $player->save_percentage = 0;



//        dd($teamLogs);

        return view('players.player', ['player' => $player]);

    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $player = Player::findOrFail($id);
        $player->is_published = !$player->is_published;
        $player->save();

        return response()->json($player);
    }
}