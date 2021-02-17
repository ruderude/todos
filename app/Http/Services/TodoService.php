<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Repositories\TodoRepository;

class TodoService
{

    private $repository = null;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($request)
    {
        $this->repository->store($request);
    }

    public function delete($id)
    {
        $this->repository->delete($id);
    }

    public function update($request, $id)
    {
        $this->repository->update($request, $id);
    }

    public function all()
    {
        return $this->repository->all();
    }

}
