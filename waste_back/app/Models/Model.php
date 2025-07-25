<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class Model extends Eloquent
{
    protected $guarded = [];

    protected $perPage = 10;

    public function resolveRouteBinding($value, $field = null)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }
    /**
     * Build search query.
     *
     * return Model
     */
    protected function buildFilter(Builder $query, array $filters, array $searchIn)
    {
        foreach ($filters as $key => $value) {
            if (!$value) {
                continue;
            }
            if ($key === 'search') {
                $query =  $this->buildSearch($query, $filters['search'] ?? '', $searchIn);
            } elseif (is_array($value)) {
                $query = $query->whereIn($key, $value);
            } else {
                $query =  $query->where($key, $value);
            }
        }
        return $query;
    }
    /**
     * Build search query.
     *
     * return Model
     */
    protected function buildSearch(Builder $query, string $search, $searchIn): Builder
    {
        // when passed null, search is disabled
        if ($searchIn === null || !is_array($searchIn) || count($searchIn) === 0) {
            return $query;
        }

        // if empty string, then we don't search at all
        $search = trim((string) $search);
        if ($search === '') {
            return $query;
        }

        $tokens = collect(explode(' ', $search));

        $searchIn = collect($searchIn)->map(function ($column) {
            return $this->parseFullColumnName($column);
        });

        $tokens->each(function ($token) use ($searchIn, $query) {
            $query->where(function (Builder $query) use ($token, $searchIn) {
                $searchIn->each(function ($column) use ($token, $query) {
                    if ($this->getKeyName() === $column['column'] && $this->getTable() === $column['table']) {
                        if (is_numeric($token) && $token === strval(intval($token))) {
                            $query->orWhere($this->materializeColumnName($column, true), intval($token));
                        }
                    } else {
                        $this->searchLike($query, $column, $token);
                    }
                });
            });
        });

        return $query;
    }

    /**
     * @param $query
     * @param $column
     * @param $token
     */
    private function searchLike($query, $column, $token): void
    {
        // MySQL and SQLite uses 'like' pattern matching operator that is case insensitive
        $likeOperator = 'like';

        // but PostgreSQL uses 'ilike' pattern matching operator for this same functionality
        if (DB::connection()->getDriverName() === 'pgsql') {
            $likeOperator = 'ilike';
        }

        $query->orWhere($this->materializeColumnName($column), $likeOperator, '%' . $token . '%');
    }

    /**
     * @param $column
     * @param bool $translated
     */
    protected function materializeColumnName($column): string
    {
        return $column['table'] . '.' . $column['column'];
    }

    /**
     * @param $column
     */
    protected function parseFullColumnName($column): array
    {
        if (Str::contains($column, '.')) {
            [$table, $column] = explode('.', $column, 2);
        } else {
            $table = $this->getTable();
        }

        return compact('table', 'column');
    }
}
