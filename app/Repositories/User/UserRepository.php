<?php

namespace App\Repositories\User;

use App\Models\User;
use App\QueryFilters\User\CodeFilter;
use Illuminate\Pipeline\Pipeline;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Cast\Bool_;

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
    public function update(string $id, array $data): bool
    {
        return $this->user->where('id', $id)->update($data);
    }
}
