<?php

namespace App\Services;

use App\Models\Like;
use App\Repositories\Like\LikeInterfaceRepository;

class LikeService
{
    /**
     * like
     *
     * @var Like
     */
    private $likeRepo;

    /**
     * __construct
     *
     * @param LIke $like
     * @return void
     */
    public function __construct(LikeInterfaceRepository $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    /**
     * create
     *
     * @param array $data
     * @return Like
     */
    public function create(array $data): Like
    {
        return $this->likeRepo->create($data);
    }

    /**
     * getSingleBy
     *
     * @param array $data
     * @return void
     */
    public function getSingleBy(array $data): Like
    {
        return $this->likeRepo->getSingleBy($data);
    }

    /**
     * delete
     *
     * @param Like $like
     * @return Like
     */
    public function delete(Like $like): Like
    {
        $this->likeRepo->delete($like);
        return $like;
    }
}
