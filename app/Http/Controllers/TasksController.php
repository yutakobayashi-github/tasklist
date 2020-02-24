<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task; 

class TasksController extends Controller
{
    
    public function index()
    {
        if (\Auth::check()) {
            //$tasks = Task::all();
            
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
        }
        return redirect('login');
    }
    
    public function create()
    {
        $task = new Task;
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        /*
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->content = $request->content;
        $task->save();
        */
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        return redirect('/');
    }

    
    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }
    
    public function edit($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
            
        }
        
        return redirect('/');
        
    
    }
    
    public function destroy($id)
    {
        $task = Task::find($id); // ここで初期化しないといけない
        if (\Auth::id() === $task->user_id) { // $tasksではなく直前に初期化した$task
            $task->delete();
        }
        return redirect('/');
    }
}
