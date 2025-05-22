<?php

namespace App\Services;

use App\Models\Task;
use DB;
use Illuminate\Support\Facades\Log;

class TaskService
{

    /*
    * Create new task
    */
    public function new(array $data)
    {
        Log::info('Create new Task');

        $task = new Task();
        $task->fill($data);
        $task->save();

        Log::info('Task created Successfully');

        return $task;
    }


    /*
    * Update a Task
    */
    public function update(array $data, $id)
    {
        $task = Task::findOrFail($id);

        return DB::transaction(function () use ($data, $task) {
            $task->fill($data);
            $task->save();
            return $task;
        });
    }


    /*
    * Delete a Task
    */
    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            Task::findOrFail($id)->firstOrFail()->delete();
        });
    }
}
