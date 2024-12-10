<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::query();

        // filter by status
        if ($request->has('status') && in_array($request->status, Todo::getAllowedStatuses())) {
            $query->where('status', $request->status);
        }

        // search by title and details
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $allowedSortFields = ['title', 'status', 'created_at'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }

        return $query->paginate(10);
    }

    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->validated());
        return response()->json($todo, 201);
    }

    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
