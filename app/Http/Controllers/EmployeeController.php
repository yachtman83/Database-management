<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Http\Controllers\response;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeRepository;
    public function __construct(Employee $employee)
    {
        $this->employeeRepository = new BaseRepository($employee);
    }




    public function index(Request $request)
    {
        #return Detail::all();
        return response()->json($this->employeeRepository->getAll($request));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        return Employee::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        // Логируем запрос для проверки
        \Log::info('Update request data', $request->all());

        // Обновляем сотрудника
        $employee->update($request->all());
        // Логируем успешное обновление
        \Log::info('Updated employee data', $employee->toArray());

        // Возвращаем обновленного сотрудника
        return response()->json($employee);
    }


    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'message' => 'Employee removed'
        ]);
    }
}
