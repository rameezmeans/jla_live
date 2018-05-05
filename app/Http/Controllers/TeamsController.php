<?php namespace App\Http\Controllers;

use App\GameLogs;
use App\GameRecords;
use App\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Team;
use View;


class TeamsController extends Controller
{
    /**
    * @var array
    */
    protected $rules =
    [
        'name' => 'required|min:2|max:32',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::orderBy('id', 'desc')->get();

        $admin = false;

        if($user = Auth::user())
        {
            if($user->id == 1){
                $admin = true;
            }
        }

        return view('teams.teams', ['teams' => $teams], ['admin' => $admin]);


    }

    public function showTeam($id){

        $team = Team::findOrFail($id);

        $team->goals = GameRecords::where('team_id', $id)->sum('goals');
        $team->assists = GameRecords::where('team_id', $id)->sum('assists');
        $team->shots = GameRecords::where('team_id', $id)->sum('shots');
        $team->sog = GameRecords::where('team_id', $id)->sum('sog');
        $team->manup = GameRecords::where('team_id', $id)->sum('manup');
        $team->down = GameRecords::where('team_id', $id)->sum('down');
        $team->ground_ball = GameRecords::where('team_id', $id)->sum('ground_ball');
        $team->TO = GameRecords::where('team_id', $id)->sum('TO');
        $team->CTO = GameRecords::where('team_id', $id)->sum('CTO');
        $team->win = GameRecords::where('team_id', $id)->sum('win');
        $team->lose = GameRecords::where('team_id', $id)->sum('lose');
        $team->allowed = GameRecords::where('team_id', $id)->sum('allowed');
        $team->saved = GameRecords::where('team_id', $id)->sum('saved');

        $team->points = $team['goals'] + $team['assists'];

        if($team['shots'] != 0)
            $team->shots_percentage = ($team['goals'] / $team['shots']) * 100;
        else
            $team->shots_percentage = 0;

        if($team['shots'] != 0)
            $team->sog_percentage = ($team['sog'] / $team['shots']) * 100;
        else
            $team->sog_percentage = 0;

        if($team['win'] + $team['lose'] != 0)
            $team->FO_percentage = ($team['win'] / ( $team['win'] + $team['lose'] )) * 100;
        else
            $team->FO_percentage = 0;

        if($team['allowed'] + $team['saved'] )
            $team->save_percentage = ($team['saved'] / ( $team['allowed'] + $team['saved'] )) * 100;
        else
            $team->save_percentage = 0;



//        dd($team);

        $gamelogs = GameLogs::where('team_id', $id)->orWhere('opponent_id', $id)->get();
        $players = Player::where('team_id', $id)->get();

//        dd($teamLogs);
//
        return view('teams.team', ['team' => $team, 'players' => $players, 'gamelogs' => $gamelogs]);

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
            $team = new Team();
            $team->name = $request->all()['name'];

//            dd($team);



//            dd($team);

//            DB::table('teams')->insert($team);


            $team->save();

            return response()->json($team);
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
        $team = Team::findOrFail($id);

        return view('team.show', ['team' => $team]);
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
            $team = Team::findOrFail($id);
            $team->name = $request->name;

            $team->save();
            return response()->json($team);
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
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json($team);
    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $team = Team::findOrFail($id);
        $team->is_published = !$team->is_published;
        $team->save();

        return response()->json($team);
    }
}