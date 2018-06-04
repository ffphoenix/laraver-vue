<?php

namespace App\Repositories\Abstracts;


abstract class AbstractRepository
{
    /**
     * @var  Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Per page number.
     *
     * @var int
     */
    protected $paginate;

    /**
     * Get all records. Allow searching, sorting and filtering records.
     *
     * @param array $data
     * @param string $query
     * @return array
     */
    public function getAll($filters)
    {
        $items = $this->model->select('*');

        $query = isset($filters['search']) ? $filters['search'] : null ;
        if (!empty($query)) {
            $this->setTableFilter($items, $query);
        }

        $showdel = isset($filters['showdel']) && $filters['showdel'] == 'true'  ? $filters['showdel'] : false;
        if (isset($filters['showdel']) && $showdel) {
            $items->withTrashed();
        }

        $this->setSortBy($items, $filters);
        $this->setPage($filters);
        $items = $items->paginate(isset($filters['limit']) ? (int)$filters['limit'] : $this->paginate);

        return $items;
    }

    /**
     * Set filter by query
     *
     */
    public function setTableFilter($items, $query)
    {
        $items->where('name', 'like', "%$query%");
    }

    /**
     * Set current page
     * @param int $currentPage
     *
     */
    public function setPage($filters)
    {
        $currentPage = isset($filters['page']) ? (int)$filters['page'] : 1;
        \Illuminate\Pagination\Paginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });
    }

    public function setSortBy($items, $filters) {
        if (isset($filters['sort'])) {
            $sort = isset($filters['sort']) ? $filters['sort'] : null;
            $sort = ($sort != 'created_at') ? $sort : 'id';

            $direction = isset($filters['dir']) && in_array($filters['dir'], ['asc', 'desc']) ? $filters['dir'] : 'desc';

            $columns = \Schema::getColumnListing($this->model->getTable());
            if (in_array($sort, $columns)) {
                $items->orderBy($sort, $direction);
            }
        }
    }

    /**
     * Find record by id.
     *
     * @param int $id
     * @return array
     */
    public function findById($id)
    {
        $item = $this->model;

        return $item->findOrFail($id);
    }

    /**
     * Add new record.
     *
     * @param array $data
     * @return  Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        $result = $this->model->create($data);
        return $result;
    }

    /**
     * Edit record.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data)
    {
        $model = $this->model->findOrFail($id);

        return $model->update($data) ? $model : false;
    }

    /**
     * Remove record.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        $query = $this->model->where('id', $id);

        return $query->delete();
    }

    /**
     * restore record.
     *
     * @param int $id
     * @return boolean
     */
    public function restore($id)
    {
        $query = $this->model->where('id', $id);

        return $query->restore();
    }
  
    /**
     * Get records for sellects.
     *
     * @return array
     */
    public function getForSelect()
    {
        return $this->model->get()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->all();
    }
  
    /**
     * Get current model.
     *
     * @return Object
     */
    public function getModel()
    {
        return $this->model->getModel();
    }
  
    /**
     * Insert record.
     *
     * @param array $data
     * @return array
     */
    public function insert($data): array
    {
        $result = $this->model->insert($data);

        return $result->toArray();
    }
}
