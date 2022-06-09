<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\UserAddRequest;
use App\Jobs\SendEMailJob;
use App\Models\Employee;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('role:admin');
        $this->userService = $userService;
    }


    public function index(Request $request)
    {
        $title = 'User';
        $paginate = 10;
        $data = User::orderBy('id', 'DESC')->paginate($paginate);

        return view('users.index', compact('data', 'title'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function search(Request $request) {
        $users = User::all();
        if ($request->keyword != '') {
            $employees = Employee::where('name','LIKE','%'.$request->keyword.'%')->get();
        }

        return response()->json([
           'employees' => $employees,
        ]);
    }


    public function create()
    {
        $title = 'Tambah user baru';
        $roles = Role::pluck('name', 'name')->all();
        $employees = Employee::pluck('name', 'id')->where('user_id', null);
        return view('users.create', compact('roles', 'title', 'employees'));
    }


    public function store(UserAddRequest $request)
    {
        try {
            $result = $this->userService->addUser($request);
            // send email
            $this->dispatch(new SendEMailJob($result->email, $result->password));

            return redirect()->back()->with('success', 'Berhsil membuat user akun ');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
