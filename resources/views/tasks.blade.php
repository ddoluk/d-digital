@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ url('store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group">
                <label for="task">Task:</label>
                <input type="text" class="form-control" id="task" placeholder="Enter your task" name="task">
            </div>
            <div class="form-group">
                <label for="image">Select Image</label>
                <input type="file" class="form-control-file" id="image" name="select_file">
            </div>
            <button type="submit" class="btn btn-secondary">Submit</button>
            <button onclick="Preview()" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                Preview
            </button>
        </form>

        @include('modal.modal')


        <br>

        <div class="d-flex justify-content-between pb-3">
            <div>
                <form action="" method="get">
                    Sorting by activate:
                    <select name="activate" id="" onchange="submit()">
                        <option value="select">Select</option>
                        <option value="yes" @if(@request('activate') == 'yes') selected @endif>
                            Yes
                        </option>
                        <option value="no" @if(@request('activate') == 'no') selected @endif>
                            No
                        </option>
                    </select>
                </form>
            </div>
            <div>
                Sorting:
                <a href="{{ route('tasks', ['activate' => request('activate'), 'name' => 'asc'])  }}">By Name</a> |
                <a href="{{ route('tasks', ['activate' => request('activate'), 'email' => 'asc'])  }}">By Email</a> |
                <a href="/">Reset</a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr class="text-center">
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Task</th>
                <th>Activate</th>
                @auth
                    <th>Edit</th>
                    <th>Delete</th>
                @endauth
            </tr>
            </thead>
            @foreach ($tasks as $task)
                <tr class="text-center">
                    <td><img src="/img/{{ $task->img }}" alt="" width="50"></td>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->email }}</td>
                    <td>{{ $task->task }}</td>
                    <td>
                        <span class="badge @if($task->activate == 'no') badge-danger @else badge-success  @endif ">{{ $task->activate  }}</span>
                    </td>
                    @auth
                        <td>
                            <a class="btn btn-primary" href="{{ url('edit').'/'.$task->id }}">edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{ url('delete').'/'.$task->id }}">delete</a>
                        </td>
                    @endauth
                </tr>
            @endforeach
        </table>


        <div class="d-flex justify-content-center">
            {{ $tasks->links() }}
        </div>
    </div>

@endsection