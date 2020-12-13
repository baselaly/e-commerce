<?php

namespace App\Repositories\Like;

use App\Models\Like;
use App\QueryFilters\Like\LikeableIdFilter;
use App\QueryFilters\Like\LikeableTypeFilter;
use App\QueryFilters\Like\UserFilter;
use Illuminate\Pipeline\Pipeline;

class LikeRepository implements LikeInterfaceRepository
{
    /**
     * like
     *
     * @var LIke
     */
    private $like;

    /**
     * __construct
     *
     * @param Like $like
     * @return void
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    /**
     * filters
     *
     * @return array
     */
    public function filters(array $filters): array
    {
        return [
            new LikeableIdFilter($filters),
            new LikeableTypeFilter($filters),
            new UserFilter($filters),
        ];
    }

    /**
     * @param array $data
     *
     * @return Like
     */
    public function create(array $data): Like
    {
        return $this->like->create($data);
    }

    /**
     * @param array $data
     *
     * @return Like
     */
    public function getSingleBy(array $data): Like
    {
        return app(Pipeline::class)
            ->send($this->like->query())
            ->through($this->filters($data))
            ->thenReturn()
            ->latest()->firstOrFail();
    }

    /**
     * @param Like $Like
     * @param array $data
     *
     * @return bool
     */
    public function update(Like $Like, array $data): bool
    {
        return $Like->update($data);
    }

    /**
     * @param array $filters
     * @param int $paginate
     *
     * @return [type]
     */
    public function getAll(array $filters = [], int $perPage = 0)
    {
        $Likes = app(Pipeline::class)
            ->send($this->like->query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->latest();

        return $perPage ? $Likes->paginate($perPage) : $Likes->get();
    }

    /**
     * delete
     *
     * @param Like $like
     * @return bool
     */
    public function delete(Like $like): bool
    {
        return $like->delete();
    }
}
