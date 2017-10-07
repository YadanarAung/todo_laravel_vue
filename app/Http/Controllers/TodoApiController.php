<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Todo;
use App\Http\Requests\UpdateTodoRequest;

class TodoApiController extends Controller
{
    public function index()
    {
        DB::statement(DB::raw('set @rownum=0'));

       $todos = Todo::select(DB::raw('@rownum := 0 r'))
        ->select(DB::raw('@rownum := @rownum + 1 AS serial_no'),'todos.*');

         return Datatables::eloquent($todos)
                ->addColumn('action', function($Todo){
                        return '<a class="btn btn-warning" href="#/detail/'.$Todo->id.'">Detail</a> 
                                <a class="btn btn-primary" href="#/edit/'.$Todo->id.'">Edit</a> 
                                <a class="btn btn-danger  btndelete" data-id="'.$Todo->id.'">Delete</a>';
                    })
                 ->toJson();

        return $datatable;
    }

    public function store(Request $request)
    {
       $this->validate($request, [
            'title' => 'required|max:500',
            'description' => 'required',
            'duedate' => 'required'
        ]);

       return Todo::create([ 'title' => request('title'),'description' => request('description'),'duedate' => request('duedate')]);
    }

   public function update($id, UpdateTodoRequest $request)
   {
        $input = $request->all();
        $todo = Todo::find($id);
        if(!$todo){
            return false;
        }

       if ($todo->update($input))
            return "update successfully!";
        else
             return "update fail!";
    }

    public function show($id)
    {
    	$todo =  Todo::query()->where('id', $id)->first();
    	return $todo;
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        if ($todo)
            $todo->delete();
        return 200;
    }
}
