<?php

namespace Basel\RepositoryPipeline;

use Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;

class Repository implements RepositoryInterface
{
    public static function getPipelineFilters(string $model, array $filters = []): array
    {
        $filters = array();
        $modelNamespace = explode('\\', $model);
        $model = $modelNamespace[count($modelNamespace) - 1];
        $path = base_path() . "/app/QueryFilters/" . $model . "/*.php";
        foreach (glob($path) as $file) {
            $class = basename($file, '.php');
            $nameSpace = "\App\QueryFilters\\" . $model . "\\" . $class;
            $filters[] = new $nameSpace($filters);
        }

        return $filters;
    }

    /**
     * get
     *
     * @param  string $model
     * @param  array $filters
     * @param  int $perPage
     * @return Collection|LengthAwarePaginator
     */
    public static function get(string $model, array $filters, int $perPage = 0): Collection|LengthAwarePaginator
    {
        try {
            $filters = self::getPipelineFilters($model, $filters);
            $model = "\\" . $model;
            $array = app(Pipeline::class)
                ->send($model::query())
                ->through($filters)
                ->thenReturn();

            return $perPage ? $array->paginate($perPage) : $array->get();
        } catch (\Throwable$e) {
            throw new Error($e->getMessage());
        }
    }

    /**
     * find
     *
     * @param  string $model
     * @param  array $filters
     * @return mixed
     */
    public static function find(string $model, array $filters = []): mixed
    {
        try {
            $filters = self::getPipelineFilters($model, $filters);
            $model = "\\" . $model;
            return app(Pipeline::class)
                ->send($model::query())
                ->through($filters)
                ->thenReturn()->firstOrFail();
        } catch (\Throwable$e) {
            throw new Error($e->getMessage());
        }
    }

    /**
     * update
     *
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * delete
     *
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}
