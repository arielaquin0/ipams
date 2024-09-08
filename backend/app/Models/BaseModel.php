<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function create(array $data): bool|self
    {
        if (empty($data)) {
            return false;
        }

        $this->fillable(array_keys($data));
        $this->fill($data);

        if ($this->save() === false) {
            return false;
        }

        return $this;
    }

    public function findRow(array $where = [], array $field = ['*']): array|self
    {
        $query = $this->query();

        if (!empty($where)) {
            $query = $query->where($where);
        }

        $model = $query->get($field)->first();

        if (empty($model)) {
            return [];
        }

        return $model;
    }


    public function findRowById(int $id, array $field = ['*']): array|self
    {
        if (empty($id)) {
            return [];
        }

        $re = $this->find($id, $field);

        if (empty($re)) {
            return [];
        }

        return $re;
    }
}
