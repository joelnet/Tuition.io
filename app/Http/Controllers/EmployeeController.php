<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;

class EmployeeController extends Controller
{
    public function show($id)
    {
        $employee = Employee::find($id);

        return $employee
            ? response()->json(['employee' => $employee])
            : abort(404);
    }

    public function store(StoreEmployee $request)
    {
        $employee = Employee::create($request->only(
            'name', 'email', 'date_of_birth', 'address1', 'address2', 'city', 'state', 'postal_code', 'country'
        ));

        return response()->json(['employee' => $employee]);
    }
}
