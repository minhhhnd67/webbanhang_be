<?php
namespace App\Repositories\Manager;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model) {
        parent::__construct($model);
    }
}
