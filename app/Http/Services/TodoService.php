<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Repositories\TodoRepository;

class TodoService
{

    private const NEW = 0;

    private $repository = null;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {

    }

    public function store($request)
    {
        $this->repository->store($request);
    }

    public function destroy(int $type, int $id)
    {

    }

    public function show(int $id)
    {

    }

    public function update($request, $id)
    {
        $res = $this->repository->update($request, $id);
        return $res;
    }

    public function all()
    {
        return $this->repository->all();
    }

}
