<?php

namespace Sahib\Repositories;

use Sahib\Repositories\Criteria\CriteriaInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * Model FQCN.
     *
     * @var string
     */
    protected $model;

    /**
     * Array of criteria.
     *
     * @var array
     */
    protected $criteria = [];

    /**
     * Default number of resources per page when using pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * Prepare the repository for query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = app($this->model)->newQuery();

        $this->applyCriteria($query);

        return $query;
    }

    /**
     * Apply a criteria.
     *
     * @param \Sahib\Repositories\Criteria\CriteriaInterface $criteria
     * @param bool $permanent
     * @return $this
     */
    public function criteria(CriteriaInterface $criteria, $permanent = false)
    {
        $this->criteria[] = compact('criteria', 'permanent');

        return $this;
    }


    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'])
    {
        return $this->query()->get($columns);
    }

    /**
     * Paginate records.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        return $this->query()->paginate(
            is_null($perPage) ? $this->perPage : $perPage,
            $columns
        );
    }

    /**
     * Paginate records with a length aware paginator.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function simplePaginate($perPage = null, $columns = ['*'])
    {
        return $this->query()->simplePaginate(
            is_null($perPage) ? $this->perPage : $perPage,
            $columns
        );
    }

    /**
     * Find a record.
     *
     * @param mixed $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * Find a record or fail.
     *
     * @param mixed $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->query()->findOrFail($id, $columns);
    }

    /**
     * Get first record.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function first($columns = ['*'])
    {
        return $this->query()->first($columns);
    }

    /**
     * Get first record or fail.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function firstOrFail($columns = ['*'])
    {
        return $this->query()->firstOrFail($columns);
    }

    /**
     * Find a record by a specified attribute.
     *
     * @param string $column
     * @param mixed $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findBy($column, $value, $columns = ['*'])
    {
        return $this->query()->where($column, '=', $value)->first($columns);
    }

    /**
     * Find a record by a specified attribute or fail if nothing found.
     *
     * @param string $column
     * @param mixed $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function findByOrFail($column, $value, $columns = ['*'])
    {
        return $this->query()->where($column, '=', $value)->firstOrFail($columns);
    }

    /**
     * Count records.
     *
     * @return int
     */
    public function count()
    {
        return $this->query()->count();
    }

    /**
     * Persist a new record.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($attributes)
    {
        return app($this->model)->create($attributes);
    }

    /**
     * Update a record.
     *
     * @param mixed $id
     * @param array $attributes
     * @return int
     */
    public function update($id, $attributes)
    {
        return $this->query()->where('id', $id)->update($attributes);
    }

    /**
     * Updates all matched records.
     *
     * @param array $attributes
     * @return int
     */
    public function updateAll($attributes)
    {
        return $this->query()->update($attributes);
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Deletes all matched records.
     *
     * @return mixed
     */
    public function deleteAll()
    {
        return $this->query()->delete();
    }

    /**
     * Apply all criteria to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    protected function applyCriteria($query)
    {
        /** @var \Sahib\Repositories\Criteria\CriteriaInterface $criteria */
        foreach ($this->criteria as $criteria) {
            $criteria['criteria']->apply($query);
        }

        // Remove non permanent criteria.
        $this->criteria = array_filter($this->criteria, function ($criteria) {
            return $criteria['permanent'];
        });

    }
}