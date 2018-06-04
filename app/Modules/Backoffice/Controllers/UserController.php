<?php

namespace Backoffice\Controllers;

use Illuminate\Http\Request;
use Backoffice\Requests\UserForm;
use App\Repositories\UserRepository;
use App\Resources\UserResource as UserResource;
use App\Resources\UsersResource as UsersResource;

class UserController extends Controller
{
    protected $userRep;

    public function __construct(UserRepository $userRepository){
        $this->userRep = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // get all the user
        $users = $this->userRep->getAll($request->all());

        // load the view and pass the user
        return new UsersResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserForm $request)
    {
        $user = $this->userRep->store($request->all());
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRep->findById($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UserForm $request)
    {
        $data = $request->all();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user = $this->userRep->update($id, $data);
        return $user ? new UserResource($user) : false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            return false;
        }
        // delete
        return $this->userRep->destroy($id);
    }

    /**
     * Restore specified resource to storage.
     *
     * @param  int  $id
     * @return Restore
     */
    public function restore($id)
    {
        return $this->userRep->restore($id);
    }
}
