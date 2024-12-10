<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;

/**
 * @OA\Info(
 *     title="Todo API",
 *     version="1.0.0",
 *     description="A simple Todo API with CRUD operations"
 * )
 */
class TodoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/todos",
     *     summary="List all todos",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"not_started", "in_progress", "completed"})
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search in title and details",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(type="string", enum={"title", "status", "created_at"})
     *     ),
     *     @OA\Parameter(
     *         name="sort_direction",
     *         in="query",
     *         description="Sort direction",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of todos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="title", type="string"),
     *                     @OA\Property(property="details", type="string"),
     *                     @OA\Property(property="status", type="string"),
     *                     @OA\Property(property="created_at", type="string", format="datetime"),
     *                     @OA\Property(property="updated_at", type="string", format="datetime")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Todo::query();

        if ($request->has('status') && in_array($request->status, Todo::getAllowedStatuses())) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%");
            });
        }

        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $allowedSortFields = ['title', 'status', 'created_at'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }

        return $query->paginate(10);
    }

    /**
     * @OA\Post(
     *     path="/api/todos",
     *     summary="Create a new todo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","details","status"},
     *             @OA\Property(property="title", type="string", example="Complete project"),
     *             @OA\Property(property="details", type="string", example="Finish the API documentation"),
     *             @OA\Property(property="status", type="string", enum={"not_started", "in_progress", "completed"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Todo created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="details", type="string"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->validated());
        return response()->json($todo, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/todos/{id}",
     *     summary="Update a todo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","details","status"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="details", type="string"),
     *             @OA\Property(property="status", type="string", enum={"not_started", "in_progress", "completed"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        return response()->json($todo);
    }

    /**
     * @OA\Delete(
     *     path="/api/todos/{id}",
     *     summary="Delete a todo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Todo deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     )
     * )
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
