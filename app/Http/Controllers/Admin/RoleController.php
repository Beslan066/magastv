<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleController extends Controller
{



    public function index()
    {

        $deletedRolesCount = Role::onlyTrashed()->count();

        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.role.index',compact('roles', 'deletedRolesCount'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(StoreRequest $request)
    {

        $data = $request->validated();

        $role = Role::firstOrCreate($data);

        $role->save();

        return redirect()->route('roles.index')->with('success','Role created successfully');

    }

    public function show()
    {
    }

    public function edit(Role $role)
    {

        return view('admin.role.edit', compact('role'));
    }

    public function update(UpdateRequest $request, Role $role)
    {

        $data = $request->validated();

        $role->update($data);

        return redirect()->route('roles.index')->with('success','Role updated successfully');
    }

    public function destroy(Role $role)
    {

        $role->delete();

        return redirect()->route('roles.index')->with('success','Role deleted successfully');
    }
}
