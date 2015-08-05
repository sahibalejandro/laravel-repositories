<?php

namespace Sahib\Repositories;

use Sahib\Repositories\Criteria\CriteriaInterface;

interface RepositoryInterface
{
    /**
     * Prepare the repository for query.
     *
     * @return mixed
     */
    public function query();

    /**
     * Apply a criteria.
     *
     * @param \Sahib\Repositories\Criteria\CriteriaInterface $criteria
     * @param bool $permanent
     * @return $this
     */
    public function criteria(CriteriaInterface $criteria, $permanent = false);

    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all($columns = ['*']);

    /**
     * Paginate records.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function paginate($perPage = 15, $columns = ['*']);

    /**
     * Paginate records with a length aware paginator.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function simplePaginate($perPage = 15, $columns = ['*']);

    /**
     * Find a record.
     *
     * @param mixed $id
     * @param array $columns
     * @return mixed|null
     */
    public function find($id, $columns = ['*']);

    /**
     * Find a record or fail.
     *
     * @param mixed $id
     * @param array $columns
     * @return mixed
     * @throws \Exception
     */
    public function findOrFail($id, $columns = ['*']);

    /**
     * Get first record.
     *
     * @param array $columns
     * @return mixed|null
     */
    public function first($columns = ['*']);

    /**
     * Get first record or fail.
     *
     * @param array $columns
     * @return mixed
     * @throws \Exception
     */
    public function firstOrFail($columns = ['*']);

    /**
     * Find a record by a specified attribute.
     *
     * @param string $column
     * @param mixed $value
     * @param array $columns
     * @return mixed|null
     */
    public function findBy($column, $value, $columns = ['*']);

    /**
     * Find a record by a specified attribute or fail if nothing found.
     *
     * @param string $column
     * @param mixed $value
     * @param array $columns
     * @return mixed
     * @throws \Exception
     */
    public function findByOrFail($column, $value, $columns = ['*']);

    /**
     * Count records.
     *
     * @return int
     */
    public function count();

    /**
     * Persist a new record.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes);

    /**
     * Update a record.
     *
     * @param mixed $id
     * @param array $attributes
     * @return int
     */
    public function update($id, $attributes);

    /**
     * Updates all matched records.
     *
     * @param array $attributes
     * @return int
     */
    public function updateAll($attributes);

    /**
     * Delete a record.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Deletes all matched records.
     *
     * @return mixed
     */
    public function deleteAll();
}