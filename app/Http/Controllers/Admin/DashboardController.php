<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->paginate(5);
        $technologies = Technology::paginate(5);
        $types = Type::paginate(5);
        return view('admin.home', compact('projects', 'technologies', 'types'));
    }
}
