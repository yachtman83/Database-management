<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetailRequest;
use App\Http\Requests\UpdateDetailRequest;
use App\Models\Detail;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;


class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $detailRepository;

    public function __construct(Detail $detail)
    {
        $this->detailRepository = new BaseRepository($detail);
    }




    public function index(Request $request)
    {
        #return Detail::all();
        return response()->json($this->detailRepository->getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailRequest $request)
    {
        return Detail::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Detail $detail)
    {
        return $detail;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailRequest $request, Detail $detail)
    {
        $detail->update($request->all());
        return $detail;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detail $detail)
    {
        $detail->delete();
        return response()->json([
            'message' => 'Detail removed'
        ]);
    }
}
