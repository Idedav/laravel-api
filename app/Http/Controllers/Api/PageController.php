<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class PageController extends Controller
{
    public function index()
    {
        $projects = Project::with('technologies', 'type')->paginate(6);
        return response()->json($projects);
    }

    public function projectBySlug($slug)
    {
        $project = Project::where('slug', $slug)->with('technologies', 'type')->first();

        if ($project->image) {
            $project->image = asset('storage/' . $project->image);
        } else {
            $project->image = asset('storage/uploads/Placeholder.png');
        }

        if ($project) {
            $success = true;
        } else {
            $success = false;
        }

        return response()->json(compact('project', 'success'));
    }
}
