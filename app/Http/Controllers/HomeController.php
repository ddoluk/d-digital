<?php

namespace App\Http\Controllers;

use Image;
use App\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return redirect('/');
    }

    public function edit($id)
    {

        return view('edit', [
            'task' => Task::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!is_null($request->file('select_file'))) {

            $image = $request->file('select_file');
            $md5ImgName = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $md5ImgName);

            $fullPathToImg = public_path('img') . DIRECTORY_SEPARATOR . $md5ImgName;

            $resizeImg = Image::make($fullPathToImg)
                ->resize(320, 240)
                ->save($fullPathToImg);

            $task->img = $md5ImgName;
        }


        $task->name = $request->name;
        $task->email = $request->email;
        $task->task = $request->task;
        $task->activate = $request->activate;


        $task->save();

        return redirect('/')->with('success', "Changes saved successfully.");
    }

    public function delete($id)
    {
        Task::destroy($id);

        return redirect()->route('home');
    }
}
