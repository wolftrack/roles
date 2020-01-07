<?php

namespace Wolfpack\Roles\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Wolfpack\Roles\Exceptions\RoleAlreadyExists;

class Role extends Model
{
    protected $guarded = [];

    public static function create(array $attributes = [])
    {
        try {
            return static::query()->create($attributes);
        } catch (Exception $exception) {
            if ($exception instanceof QueryException && $exception->errorInfo[0] == 23000) {
                throw new RoleAlreadyExists;
            }

            throw $exception;
        }
    }

    public function findById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function findByName($name)
    {
        return $this->where('name', $name)->first();
    }

    public function findBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }
}
