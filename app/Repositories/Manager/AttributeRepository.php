<?php
namespace App\Repositories\Manager;

use App\Models\Attribute;
use App\Repositories\BaseRepository;

class AttributeRepository extends BaseRepository
{
    public function __construct(Attribute $model) {
        parent::__construct($model);
    }
}
