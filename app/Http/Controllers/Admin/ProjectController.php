<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Functions\Helper;
use App\Http\Requests\ProjectRequest as RequestsProjectRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Project';
        $method = 'POST';
        $route = route('admin.projects.store');
        $project = null;
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create-edit', compact('title', 'method', 'route', 'project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $form_data = $request->all();

        $new_project = new Project();

        $new_project->name = $form_data['name'];
        $new_project->slug = Helper::generateSlug($form_data['name'], Project::class);
        $new_project->description = $form_data['description'];
        $new_project->type_id = $form_data['type'];

        if (array_key_exists('image', $form_data)) {

            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();

            $form_data['image'] = Storage::put('uploads', $form_data['image']);

            $new_project->image = $form_data['image'];
        }

        $new_project->save();

        if (array_key_exists('technologies', $form_data)) {
            $new_project->technologies()->attach($form_data['technologies']);
        }

        return redirect()->route('admin.projects.show', $new_project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project)
    {
        $project = Project::find($project);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $title = 'Edit Project';
        $method = 'PUT';
        $route = route('admin.projects.update', $project);
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create-edit', compact('title', 'method', 'route', 'project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $form_data = $request->all();

        $project->slug = Helper::generateSlug($form_data['name'], Project::class);

        if (array_key_exists('image', $form_data)) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();

            $form_data['image'] = Storage::put('uploads', $form_data['image']);
        }

        $project->update($form_data);

        if (array_key_exists('technologies', $form_data)) {
            $project->technologies()->sync($form_data['technologies']);
        } else {
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project)
    {
        $project = Project::find($project);

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }
}
