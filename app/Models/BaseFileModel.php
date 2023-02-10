<?php

namespace App\Models;

use DongttFd\LaravelUploadModel\Contracts\UploadOnEloquentModel;
use DongttFd\LaravelUploadModel\Eloquent\UploadFileEloquent;

class BaseFileModel extends BaseModel implements UploadOnEloquentModel
{
    use UploadFileEloquent;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
}
