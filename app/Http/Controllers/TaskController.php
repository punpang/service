<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TaskCreated;
use App\Events\TaskRemoved;
use App\Task;

class TaskController extends Controller
{
    public function fetchAll($id)
    {
        //$tasks = Task::all();
        $tasks = Task::whereIn("id", [$id])->get();
        //return response()->json($tasks);
        return $tasks;
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $task = Task::find(request("id"));
        $task->title = request("title");
        $task->completed = request("completed");
        $task->update();
        //$task->update(request()->all());
        //$task->update();
        //$task = Task::create($request->all());

        broadcast(new TaskCreated($task));
        return response()->json("added");
    }

    public function delete($id)
    {
        $task = Task::find($id);
        broadcast(new TaskRemoved($task));
        Task::destroy($id);
        return response()->json("deleted");
    }
}
