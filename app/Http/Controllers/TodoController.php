<?php

namespace App\Http\Controllers;

use App\Models\{Todo, User};
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return view('todos.index')->with([
            'todos' => $user->todos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function update(Request $request)
    {
        /**
         * @var Todo $todo
         */
        $todo = $request->attributes->get('todo');

        try {
            $todo->update(
                $request->all($todo->getFillable())
            );

            $todo->save();
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'error' => false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        /**
         * @var Todo $todo
         */
        $todo = $request->attributes->get('todo');

        try {
            $todo->delete();
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'error' => false
        ]);
    }
}
