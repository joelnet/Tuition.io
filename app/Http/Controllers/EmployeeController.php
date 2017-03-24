<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;

class EmployeeController extends Controller
{
    const FIELDS = ['name', 'email', 'date_of_birth', 'address1', 'address2', 'city', 'state', 'postal_code', 'country'];

    public function show($id)
    {
        $employee = Employee::find($id);

        return $employee
            ? response()->json(['employee' => $employee])
            : response()->json(['message' => 'Not found'], 404);
    }

    public function store(StoreEmployee $request)
    {
        return response()->json(['employee' => Employee::create($request->only(self::FIELDS))]);
    }

    public function update(StoreEmployee $request, $id)
    {
        abort(500, 'not implemented');
    }

    public function destroy($id)
    {
        Employee::destroy($id);
        abort(204);
    }
}
