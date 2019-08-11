@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ url('update').'/'.$task->id }}" method="post" class="form-horizontal"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"
                       value="{{ $task->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
                       value="{{ $task->email }}">
            </div>
            <div class="form-group">
                <label for="task">Task:</label>
                <input type="text" class="form-control" id="task" placeholder="Enter you task" name="task"
                       value="{{ $task->task }}">
            </div>
            <div class="form-group">
                <label for="activate">Activate</label>
                <select class="custom-select" name="activate">
                    <option value="yes" @if ($task->activate == 'yes') selected @endif>
                        Yes
                    </option>
                    <option value="no" @if ($task->activate  == 'no') selected @endif>
                        No
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Select Image</label>
                <input type="file" class="form-control-file" id="image" name="select_file">
            </div>
            <button type="submit" class="btn btn-secondary">Submit</button>
            </button>
        </form>
    </div>
@endsection