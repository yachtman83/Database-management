<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalary_historyRequest;
use App\Http\Requests\UpdateSalary_historyRequest;
use App\Models\SalaryHistory;
use App\Http\Controllers\response;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class SalaryHistoryController extends Controller
{
    protected $salaryRepository;
    public function __construct(SalaryHistory $salary_history)
    {
        $this->salaryRepository = new BaseRepository($salary_history);
    }




    public function index(Request $request)
    {
        #return Detail::all();
        return response()->json($this->salaryRepository->getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalary_historyRequest $request)
    {
        return SalaryHistory::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(SalaryHistory $salary_history)
    {
        return $salary_history;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalary_historyRequest $request, SalaryHistory $salary_history)
    {
        $salary_history->update($request->all());
        return $salary_history;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalaryHistory $salary_history)
    {
        $salary_history->delete();
        return response()->json([
            'message' => 'Record removed'
        ]);
    }
}
