<?php

namespace App\Repositories;

use App\Repositories\Abstracts\AbstractRepository;
use App\Models\User;

class UserRepository extends AbstractRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
        $this->paginate = env('PAGINATE', 10);
    }

    public function store($data)
    {
        $data['password'] = bcrypt($data['password']);
        return parent::store($data);
    }

    public function update($id, $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return parent::update($id, $data);
    }

    public function setTableFilter($items, $query)
    {
        $items->where('name', 'like', "%$query%")->orWhere('email', 'like', "%$query%");
    }
}
