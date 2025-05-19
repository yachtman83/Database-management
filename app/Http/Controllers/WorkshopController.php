<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkshopRequest;
use App\Http\Requests\UpdateWorkshopRequest;
use App\Models\Workshop;
use Illuminate\Http\Request;
use App\Http\Controllers\response;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1️⃣ Получаем запросы из URL (GET-параметры)
        $sortBy = $request->query('sortBy', 'created_at'); // Поле для сортировки (по умолчанию — created_at)
        $sortOrder = $request->query('sortOrder', 'desc'); // Порядок сортировки (desc/asc)
        $search = $request->query('search'); // Поиск по названию
        $perPage = $request->query('perPage', 10); // Количество элементов на странице (по умолчанию 10)

        // 2️⃣ Запрос к БД с учетом фильтров
        $query = Workshop::query();

        // 3️⃣ Фильтрация (поиск по названию)
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // 4️⃣ Сортировка
        $query->orderBy($sortBy, $sortOrder);

        // 5️⃣ Пагинация
        $workshops = $query->paginate($perPage);

        return response()->json($workshops);
        //return Workshop::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkshopRequest $request)
    {
        return Workshop::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Workshop $workshop)
    {
        return $workshop;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkshopRequest $request, Workshop $workshop)
    {
        $workshop->update($request->all());
        return $workshop;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->delete();
        return response()->json([
            'message' => 'Workshop removed'
        ]);
    }

    public function attachProduct(Request $request, $workshop_id)
    {
        $workshop = Workshop::findOrFail($workshop_id);
        $product_id = $request->input('product_type_id');

        // Привязываем продукцию (без дубликатов)
        $workshop->productTypes()->syncWithoutDetaching([$product_id]);

        return response()->json(['message' => 'Продукция добавлена в цех'], 201);
    }

    public function detachProduct(Request $request, $workshop_id)
    {
        $workshop = Workshop::findOrFail($workshop_id);
        $product_id = $request->input('product_type_id');

        // Удаляем связь с продукцией
        $workshop->productTypes()->detach([$product_id]);

        return response()->json(['message' => 'Продукция удалена из цеха'], 200);
    }


}
