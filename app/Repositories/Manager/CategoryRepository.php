<?php
namespace App\Repositories\Manager;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model) {
        parent::__construct($model);
    }
}
