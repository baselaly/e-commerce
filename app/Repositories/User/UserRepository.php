<?php

namespace App\Repositories\User;

use App\Models\User;
use App\QueryFilters\User\CodeFilter;
use App\QueryFilters\User\EmailFilter;
use Illuminate\Pipeline\Pipeline;

class UserRepository implements UserInterfaceRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $data
     * 
     * @return User
     */
    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    /**
     * @return User
     */
    public function getSingleBy(array $data): User
    {
        return app(Pipeline::class)
            ->send($this->user->query())
            ->through([
                new CodeFilter($data),
                new EmailFilter($data)
            ])
            ->thenReturn()
            ->firstOrFail();
    }

    /**
     * @param string $id
     * @param array $data
     * 
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }
}
