<?php namespace App\Http\Controllers;

use App\GameLogs;
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
            $team->goals = $request->all()['goals'];
            $team->assists = $request->all()['assists'];
            $team->shots = $request->all()['shots'];
            $team->sog = $request->all()['sog'];
            $team->manup = $request->all()['manup'];
            $team->down = $request->all()['down'];
            $team->ground_ball = $request->all()['ground_ball'];
            $team->TO = $request->all()['TO'];
            $team->CTO = $request->all()['CTO'];
            $team->win = $request->all()['win'];
            $team->lose = $request->all()['lose'];
            $team->allowed = $request->all()['allowed'];
            $team->saved = $request->all()['saved'];

            $team->points = $team['goals'] + $team['assists'];
            $team->shots_percentage = ($team['goals'] / $team['shots']) * 100;
            $team->sog_percentage = ($team['sog'] / $team['shots']) * 100;
            $team->FO_percentage = ($team['win'] / ( $team['win'] + $team['lose'] )) * 100;
            $team->save_percentage = ($team['saved'] / ( $team['allowed'] + $team['saved'] )) * 100;

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
            $team->goals = $request->all()['goals'];
            $team->assists = $request->all()['assists'];
            $team->shots = $request->all()['shots'];
            $team->sog = $request->all()['sog'];
            $team->manup = $request->all()['manup'];
            $team->down = $request->all()['down'];
            $team->ground_ball = $request->all()['ground_ball'];
            $team->TO = $request->all()['TO'];
            $team->CTO = $request->all()['CTO'];
            $team->win = $request->all()['win'];
            $team->lose = $request->all()['lose'];
            $team->allowed = $request->all()['allowed'];
            $team->saved = $request->all()['saved'];

            $team->points = $team['goals'] + $team['assists'];
            $team->shots_percentage = ($team['goals'] / $team['shots']) * 100;
            $team->sog_percentage = ($team['sog'] / $team['shots']) * 100;
            $team->FO_percentage = ($team['win'] / ( $team['win'] + $team['lose'] )) * 100;
            $team->save_percentage = ($team['saved'] / ( $team['allowed'] + $team['saved'] )) * 100;


//            dd($team);

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