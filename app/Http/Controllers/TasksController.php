<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task; 

class TasksController extends Controller
{
    
    public function index()
    {
        if (Auth::check()) {
        $tasks = Task::all();
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }
    }
    
    public function create()
    {
        if (Auth::check()) {
        $task = new Task;
        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    }

    
    public function store(Request $request)
    {
        if (Auth::check()) {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
    }
    return redirect('/');
    }

    
    public function show($id)
    {
        if (Auth::check()) {
        $task = Task::find($id);
        return view('tasks.show', [
            'task' => $task,
        ]);
    }
    }
    
    public function edit($id)
    {
        if (Auth::check()) {
        $task = Task::find($id);
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        if (Auth::check()) {
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        }
        return redirect('/');
    
    }
    
    public function destroy($id)
    {
        if (Auth::check()) {
        $task = Task::find($id);
        $task->delete();
}
        return redirect('/');
    
    }
}
