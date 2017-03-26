<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Repositories\EmployeeRepositoryInterface;

class EmployeeController extends Controller
{
    private $repository;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function show($id)
    {
        $employee = $this->repository->find($id);

        return $employee
            ? response()->json(['employee' => $employee])
            : response()->json(['message' => 'Not found'], 404);
    }

    public function store(StoreEmployee $request)
    {
        $data = $request->only($this->repository->getFields());

        return response()->json(['employee' => $this->repository->create($data)]);
    }

    public function update(StoreEmployee $request, $id)
    {
        $data = $request->only($this->repository->getFields());

        $this->repository->update($data, $id);
        abort(204);
    }

    public function destroy($id)
    {
        $this->repository->destroy($id);
        abort(204);
    }
}
