<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function get($id)
    {
        $employee = Employee::find($id);

        return $employee
            ? response()->json([
                  'employee' => $employee
              ])
            : abort(404);
    }
}
