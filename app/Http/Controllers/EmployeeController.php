<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\EmployeeAddRequest;
use App\Jobs\SendEMailJob;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{

    private EmployeeService $employeeService;


    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }


    public function index(Request $request)
    {
        $title = 'Pengguna';
        $paginate = 10;
        $employees= Employee::paginate($paginate);
        return view('employees.index', compact('employees', 'title'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);

    }

    public function create()
    {
        $title = 'Tambah Pengguna';
        $roles = Role::pluck('name', 'name')->all();
        return view('employees.create', compact('title', 'roles'));
    }

    public function store(EmployeeAddRequest $request)
    {
        try {
            $user = $this->employeeService->addEmployee($request);
            $this->dispatch(new SendEMailJob($user->email, $user->password));

            return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil ditambah');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception)->withInput($request->all());
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception)->withInput($request->all());
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
