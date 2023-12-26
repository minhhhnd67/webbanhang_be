<?php
namespace App\Repositories\Manager;

use App\Models\AttributeOption;
use App\Repositories\BaseRepository;

class AttributeOptionRepository extends BaseRepository
{
    public function __construct(AttributeOption $model) {
        parent::__construct($model);
    }
}
