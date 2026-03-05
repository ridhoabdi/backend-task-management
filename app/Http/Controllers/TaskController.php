<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tasks = Task::where('id_user', Auth::id())
            ->latest()
            ->get();

        return TaskResource::collection($tasks);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'id_status' => $request->id_status,
            'id_user' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task berhasil dibuat.',
            'data' => new TaskResource($task)
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $task = Task::where('id_task', $id)
                ->where('id_user', Auth::id())
                ->first();

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new TaskResource($task)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan.'
            ], 404);
        }
    }

    public function update(TaskRequest $request, string $id): JsonResponse
    {
        try {
            $task = Task::where('id_task', $id)
                ->where('id_user', Auth::id())
                ->first();

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task tidak ditemukan.'
                ], 404);
            }

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'id_status' => $request->id_status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task berhasil diupdate.',
                'data' => new TaskResource($task)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan.'
            ], 404);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $task = Task::where('id_task', $id)
                ->where('id_user', Auth::id())
                ->first();

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task tidak ditemukan.'
                ], 404);
            }

            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan.'
            ], 404);
        }
    }
}