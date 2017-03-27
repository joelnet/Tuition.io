<?php

namespace App\Repositories;

use App\Http\Requests\StoreEmployee;

interface EmployeeRepositoryInterface
{
    public function getFields();

    public function find(int $id);

    public function create(array $data);

    public function update(array $data, int $id);

    public function destroy(int $id);

    public function all();
}
