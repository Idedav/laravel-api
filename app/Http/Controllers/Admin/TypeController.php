<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Functions\Helper;
use App\Http\Requests\TypeRequest;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function projectsTypes()
    {
        $types = Type::all();
        return view('admin.types.projects-types', compact('types'));
    }
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
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
    public function store(TypeRequest $request)
    {

        $exixts = Type::where('name', $request->name)->first();

        if ($exixts) {
            return redirect()->route('admin.types.index')->with('error', 'Type already exists');
        }

        $new_type = new Type();
        $new_type->name = $request->name;
        $new_type->slug = Helper::generateSlug($request->name, Type::class);
        $new_type->save();

        return redirect()->route('admin.types.index')->with('success', 'Type added successfully');
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
    public function update(TypeRequest $request, Type $type)
    {
        $form_data = $request->all();
        $exixts = Type::where('name', $form_data['name'])->first();

        if ($exixts) {
            return redirect()->route('admin.types.index')->with('error', 'Type already exists');
        }
        $type->update($form_data);
        return redirect()->route('admin.types.index')->with('success', 'Type Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return redirect()->route('admin.types.index')->with('success', 'Type deleted successfully');
    }
}
