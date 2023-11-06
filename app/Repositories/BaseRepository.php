<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all($relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getById($id, $relations = [])
    {
        return $this->model->with($relations)->findorFail($id);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function destroy($ids)
    {
        return $this->model->destroy($ids);
    }

    public function query()
    {
        return $this->model->query();
    }

    public function getList($pageSize, $relations = [])
    {
        $data = $this->query()->with($relations);
        return $data->paginate($pageSize);
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    // public function getDataItems($parameters = array(), $with_fields = null, $paging = false, $order_by_fields = null)
    // {
    //     $data_query = $this->generateQueryBuilder($parameters, $with_fields, $order_by_fields);

    //     if ($paging) {
    //         return $data_query->paginate($this->page_size);
    //     }
    //     return $data_query->get();
    // }

    // public function generateQueryBuilder($parameters = array(), $with_fields = null, $order_by_fields = null, $ignore_param_deleted = false)
    // {
    //     if ($ignore_param_deleted) {
    //         $data_query = $this->model::whereRaw("1=1");
    //     } else {
    //         $data_query = $this->model::where('is_deleted', NO_DELETED);
    //     }


    //     //Add with
    //     if (!empty($with_fields)) {
    //         $data_query = $data_query->with($with_fields);
    //     }

    //     //Add parameter
    //     if (!empty($parameters)) {
    //         $keyword_search = '';
    //         if (isset($parameters[$this->parameter_search])) {
    //             $keyword_search = $parameters[$this->parameter_search];
    //             unset($parameters[$this->parameter_search]);
    //         }
    //         foreach ($parameters as $parameter_key => $parameter_value) {
    //             if (is_null($parameter_value) || empty($parameter_key)) {
    //                 continue;
    //             }
    //             if (!empty($keyword_search) && !empty($this->allow_search_fields)) {
    //                 $data_query_search = array();
    //                 foreach ($this->allow_search_fields as $field_item) {
    //                     if (!empty($field_item)) {
    //                         $data_query_search[] = "`$field_item` like '%$keyword_search%'";
    //                     }
    //                 }
    //                 if (!empty($data_query_search)) {
    //                     $data_query = $data_query->whereRaw("(" . implode(" or ", $data_query_search) . ")");
    //                 }
    //             }

    //             if (is_array($parameter_value) && $parameter_value != '') {
    //                 $data_query = $data_query->whereIn($parameter_key, $parameter_value);
    //             } elseif (!is_null($parameter_value)) {
    //                 $data_query = $data_query->where($parameter_key, $parameter_value);
    //             }
    //         }
    //     }

    //     //Add order by
    //     if (!empty($order_by_fields)) {
    //         if (is_array($order_by_fields)) {
    //             foreach ($order_by_fields as $order_by_column => $order_by_type) {
    //                 $data_query = $data_query->orderBy($order_by_column, $order_by_type);
    //             }
    //         } else {
    //             $data_query = $data_query->orderBy($order_by_fields);
    //         }
    //     }

    //     return $data_query;
    // }
}

