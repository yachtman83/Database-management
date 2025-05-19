<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Получение списка записей с фильтрацией, сортировкой и пагинацией.
     */
    public function getAll(Request $request)
{
    $query = $this->model->query();

    // Фильтрация
    if ($request->has('filter')) {
        foreach ($request->input('filter') as $field => $value) {
            if (!empty($value)) {
                $query->where($field, 'LIKE', "%$value%");
            }
        }
    }

    // Сортировка
    $sortBy = $request->input('sort_by', 'id');
    $sortOrder = $request->input('sort_order', 'asc');
    $query->orderBy($sortBy, $sortOrder);

    // Пагинация
    $perPage = $request->input('per_page', 10);
    $paginator = $query->paginate($perPage);

    // ***ФИКС: сохраняем параметры в ссылках пагинации***
    $paginator->appends($request->except('page'));

    return $paginator;
}
}
