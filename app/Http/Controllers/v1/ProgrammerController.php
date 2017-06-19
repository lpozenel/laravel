<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\v1\ProgrammerService; 

class ProgrammerController extends Controller
{
    protected $programmers;
    public function __construct(ProgrammerService $service){
        $this->programmers = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();

       $data = $this->programmers->getProgrammers($parameters);

       return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $programmer = $this->programmers->addProgrammer($request);

            return response()->json($programmer, 201);
        } catch(Exception $e) {
            return response()->json([message => $e->getMessage()],500);
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
        $data = $this->programmers->getProgrammer($id);

       return response()->json($data);
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
        try{
        $programmer = $this->programmers->updateProgrammer($request, $id);

            return response()->json($programmer, 200);
        } 
        catch(ModelNotFoundException $ex) {
            throw $ex;
        }

        catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
        try{
        $programmer = $this->programmers->deleteProgrammer($id);

            return response()->make('', 204);
        } 
        catch(ModelNotFoundException $ex) {
            throw $ex;
        }

        catch(Exception $e) {
            return response()->json([message => $e->getMessage()],500);
        }
    }
}
