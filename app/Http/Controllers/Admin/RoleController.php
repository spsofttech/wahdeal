<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $branch = Branch::where('status','1')->get();
        return view('admin.role',compact('branch'));
    }

    public function get_role_using_branch(Request $request)
    {
        $role = Role::where('branch_id', $request->id)->get();

        return response()->json([
            'status' => 'success',
            'roles' => $role
        ]);
    }

     public function insert_role(Request $request)
    {
        $branch = $request->branch;
        $role = $request->role;

        if(!empty($role)){
            Role::where('branch_id', $branch)->delete();
            foreach($role as $val){
                $newrole = new Role;
                $newrole->branch_id = $branch;
                $newrole->role = $val;
                $newrole->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Role added successfull',
        ]);
    }
}
