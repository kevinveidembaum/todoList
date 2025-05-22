<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use PhpParser\Node\Stmt\TryCatch;

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

        try {
            $task = $this->taskService->new($request->validated());

            Log::info('Task Created Successfully');
            return new TaskResource($task);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'An error occurred while saving new Task!',
                'data'    => [],
            ], 500);
        }
    }

    /*
    * Update a Task
    */
    public function update(StoreTaskRequest $request, $id)
    {
        Log::info("Update Task");
        try {
            $task = $this->taskService->update($request->validated(), $id);

            Log::info('Task Updated Successfully');
            return new TaskResource($task);
        } catch (ModelNotFoundException $e) {
            Log::error("Task not found: id {$id}");

            return response()->json([
                'message' => 'Task not Found.',
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'An error occurred while updating a Task!',
                'data'    => [],
            ], 500);
        }
    }


    /*
    * Permanent Delete a Task
    */
    public function destroy($id)
    {
        Log::info("Delete Task");
        try {
            $this->taskService->delete($id);

            Log::info('Task Deleted Successfully');

            return response()->json([
                'message' => 'Task Successfully Deleted.',
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Task not found: id {$id}");

            return response()->json([
                'message' => 'Task not Found.',
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'An error occurred while deleting a Task!',
                'data'    => [],
            ], 500);
        }
    }
}
