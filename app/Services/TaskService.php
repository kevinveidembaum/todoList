<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskService{

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







}
