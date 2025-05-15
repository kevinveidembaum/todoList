<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Store a new FinancialControlItem.
     */
    public function store(StoreTaskRequest $request)
    {
        Log::info("Create Task");

        try
        {
            $task = $this->taskService->new($request->validated());

            Log::info('Task Created Successfully');
            return new TaskResource($task);
        }catch(Exception $e){
            Log::error($e);

            return response()->json([
                'message' => 'An error occurred while saving new Task!',
                'data'    => [],
            ], 500);
        }
    }
}
