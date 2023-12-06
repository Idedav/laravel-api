<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Technology;
use Illuminate\Support\Str;
use App\Functions\Helper;
use App\Http\Requests\TechnologyRequest;
use App\Models\Project;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::all();
        return view('admin.technologies.index', compact('technologies'));
    }

    public function projectsTechnologies(Technology $technology)
    {
        $projects = $technology->projects;
        return view('admin.technologies.projects-technologies', compact('technology', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnologyRequest $request)
    {
        $exixts = Technology::where('name', $request->name)->first();
        if ($exixts) {
            return redirect()->route('admin.technologies.index')->with('error', 'Technology already exists');
        } else {
            $new_technology = new Technology();
            $new_technology->name = $request->name;
            $new_technology->slug = Str::slug($request->name, '-');
            $new_technology->save();
            return redirect()->route('admin.technologies.index')->with('success', 'Technology added successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TechnologyRequest $request, Technology $technology)
    {

        $form_data = $request->all();

        //

        $exixts = Technology::where('name', $request->name)->first();
        if ($exixts) {
            return redirect()->route('admin.technologies.index')->with('error', 'Technology already exists');
        }

        $form_data['slug'] = Helper::generateSlug($request->name, Technology::class);



        $technology->update($form_data);



        return redirect()->route('admin.technologies.index')->with('success', 'Technology Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technologies.index')->with('success', 'Technology deleted successfully');
    }
}
