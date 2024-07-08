<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('search-form');
    }

    /**
     * Handle the search autocomplete request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAutocomplete(Request $request): JsonResponse
    {
        $res = Task::select("name")
            ->where("name", "LIKE", "%{$request->term}%")
            ->get();

        return response()->json($res);
    }
}
