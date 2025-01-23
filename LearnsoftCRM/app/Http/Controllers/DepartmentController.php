<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DepartmentRepository;
use App\Models\Employee; // Include Employee model
use Illuminate\Http\Request;
use Flash;

class DepartmentController extends AppBaseController
{
    /** @var DepartmentRepository $departmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Query the departments using the repository
        $departments = $this->departmentRepository->query();
        
        if ($search) {
            // Search all relevant columns
            $departments = $departments->where(function ($query) use ($search) {
                $query->where('dept_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        // Paginate results (10 per page)
        $departments = $departments->paginate(10);
        
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new Department.
     */
    public function create()
    {
        $employees = Employee::all()->pluck('full_name', 'id'); // Get employees for dropdown
        return view('departments.create', compact('employees'));
    }

    /**
     * Store a newly created Department in storage.
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        Flash::success('Department saved successfully.');

        return redirect(route('departments.index'));
        $department->update(['employee_id' => $request->employee_id]); // Add employee_id in the update logic

    }

    /**
     * Display the specified Department.
     */
    public function show($id)
    {
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     */
    public function edit($id)
    {
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        $employees = Employee::all()->pluck('full_name', 'id'); // Get employees for dropdown
        return view('departments.edit', compact('department', 'employees'));
    }

    /**
     * Update the specified Department in storage.
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        $department = $this->departmentRepository->update($request->all(), $id);

        Flash::success('Department updated successfully.');

        return redirect(route('departments.index'));

        $input = $request->all();
        $department->update(['employee_id' => $request->employee_id]); 

    }

    /**
     * Remove the specified Department from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            Flash::error('Department not found');

            return redirect(route('departments.index'));
        }

        $this->departmentRepository->delete($id);

        Flash::success('Department deleted successfully.');

        return redirect(route('departments.index'));
    }
}
