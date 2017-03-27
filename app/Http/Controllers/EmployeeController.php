<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Repositories\EmployeeRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

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
            : response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
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

        return abort(Response::HTTP_NO_CONTENT);
    }

    public function destroy($id)
    {
        $this->repository->destroy($id);

        return abort(Response::HTTP_NO_CONTENT);
    }

    public function all()
    {
        return response()->json(['employees' => $this->repository->all()]);
    }
}
