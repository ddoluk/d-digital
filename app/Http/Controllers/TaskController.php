<?php

namespace App\Http\Controllers;


use Image;
use Validator;
use App\Task as Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            'name', 'email',
        ];

        $queries = [];


        if ($request->has('activate') && $request->activate != '') {
            $tasks = Task::where('activate', $request->activate)
                ->paginate(3)
                ->appends('activate', $request->activate);
            $queries['activate'] = $request->activate;
        }

        foreach ($columns as $column) {
            if ($request->has($column)) {
                $queries[$column] = $request->{$column};
                $tasks = Task::orderBy($column, $request->{$column})
                    ->paginate(3)
                    ->appends($queries);
            }
        }

        if (!$request->all() || $request->activate == 'select') {
            $tasks = Task::orderBy('created_at', 'desc')->paginate(3);
        }

        return view('tasks', [
            'tasks' => $tasks,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'task' => 'required',
            'select_file' => 'required|image|mimes:jpeg,jpg,gif,png',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $image = $request->file('select_file');
        $md5ImgName = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img'), $md5ImgName);

        $fullPathToImg = public_path('img') . DIRECTORY_SEPARATOR . $md5ImgName;

        $resizeImg = Image::make($fullPathToImg)
            ->resize(320, 240)
            ->save($fullPathToImg);

        $task = new Task();
        $task->name = $request->name;
        $task->email = $request->email;
        $task->task = $request->task;
        $task->img = $md5ImgName;
        $task->save();

        return redirect('/')->with('success', "Task was saved successfully.");

    }
}
