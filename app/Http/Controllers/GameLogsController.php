<?php namespace App\Http\Controllers;

use App\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\GameLogs;
use App\Game;
use View;


class GameLogsController extends Controller
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
        $gamelogs = GameLogs::orderBy('id', 'desc')->get();
        $games = Game::orderBy('id', 'desc')->get();
        $teams = Team::orderBy('id', 'desc')->get();
        $opponents = Team::orderBy('id', 'desc')->get();

        $admin = false;

        if($user = Auth::user())
        {
            if($user->id == 1){
                $admin = true;
            }
        }


        return view('gamelogs.gamelogs', ['admin' => $admin ,'gamelogs' => $gamelogs, 'games' => $games, 'teams' => $teams, 'opponents' => $opponents]);
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

//        dd($request->all());

        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $gamelog = new GameLogs();
            $gamelog->game_id = $request->game_id;
            $gamelog->team_id = $request->team_id;
            $gamelog->opponent_id = $request->opponent_id;
            $gamelog->date_played = Carbon::createFromFormat('m/d/Y', $request->date_played);
            $gamelog->venue = $request->venue;
            $gamelog->score = $request->score;
            $gamelog->save();

            $gamelog->team_name = Team::findOrFail($request->team_id)->name;
            $gamelog->game_name = Game::findOrFail($request->game_id)->name;
            $gamelog->opponent_name = Team::findOrFail($request->opponent_id)->name;


            return response()->json($gamelog);
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
        $gamelog = GameLogs::findOrFail($id);

        return view('team.show', ['team' => $gamelog]);
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
            $gamelog = GameLogs::findOrFail($id);
            $gamelog->game_id = $request->game_id;
            $gamelog->team_id = $request->team_id;
            $gamelog->opponent_id = $request->opponent_id;
            $gamelog->save();
            return response()->json($gamelog);
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
        $gamelog = GameLogs::findOrFail($id);
        $gamelog->delete();

        return response()->json($gamelog);
    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $gamelog = GameLogs::findOrFail($id);
        $gamelog->is_published = !$gamelog->is_published;
        $gamelog->save();

        return response()->json($gamelog);
    }
}