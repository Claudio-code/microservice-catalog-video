<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;

    /** @var string[] */
    protected $fillable = ['name', 'is_active'];

    /** @var string[] */
    protected $dates = ['deleted_at'];

    /** @var string[] */
    protected $casts = ['id' => 'string', 'is_active' => 'boolean'];

    /** @var bool $incrementing */
    public $incrementing = false;
}
