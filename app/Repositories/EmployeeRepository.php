<?php

namespace App\Repositories;

use App\Employee;
use App\Repositories\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getFields()
    {
        return ['name', 'email', 'date_of_birth', 'address1', 'address2', 'city', 'state', 'postal_code', 'country'];
    }

    public function find(int $id)
    {
        return Employee::find($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update(array $data, int $id)
    {
        return Employee::where('id', $id)
            ->update($data);
    }

    public function destroy(int $id)
    {
        return Employee::destroy($id);
    }

    // TODO: paging
    public function all()
    {
        return Employee::all();
    }
}
