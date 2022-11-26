<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->tasks;

    }


    public function store(Request $request)
    {
        $validatedData = $request -> validate([
            'title' => 'required',
            'due_date' => 'required',
            'category_id' => 'required'
        ]);

        $user = Auth::user();

        if(Category::find($validatedData['category_id'])->user_id != $user -> id ) {
            return response()->json(['message' => 'you do not have any access to delete this resource'],401);
        }

        $created = $user -> tasks() -> create($validatedData);

        if($created) {
            return $created;
        }

        return response()->json(['message' => 'some error happened'],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    public function restore() {

    }

    public function forceDelete() {

    }


    public function deleted() {

    }
}
