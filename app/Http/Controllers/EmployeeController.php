<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeUpdateRequest;
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
        $key = $request->query('key') ?? '';
        $paginate = 10;
        $employees= $this->employeeService->list($key, $paginate);
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

    public function edit($id)
    {
        $title = 'Edit Pengguna';
        $employee = Employee::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $employee->user->roles->pluck('name','name')->all();
        return view('employees.edit', compact('employee', 'title', 'roles', 'userRole'));
    }


    public function update(EmployeeUpdateRequest $request, $id)
    {
        try {
            $this->employeeService->updateEmployee($request, $id);
            return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diubah');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception)->withInput($request->all());
        }
    }


    public function destroy($id)
    {
        try {
            $this->employeeService->deleteEmployee($id);
            return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil dihapus');
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', "Gagal menghapus data");
        }
    }
}
