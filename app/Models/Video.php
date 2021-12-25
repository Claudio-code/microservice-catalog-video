<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;

    /** @var boolean */
    public $incrementing = false;

    /** @var string[] */
    protected $dates = ['deleted_at'];

    /** @var string[] */
    protected $fillable = [
        'title',
        'description',
        'year_launched',
        'opened',
        'rating',
        'duration',
    ];

    /** @var string[] */
    protected $casts = [
        'id' => 'string',
        'opened' => 'boolean',
        'year_launched' => 'integer',
        'duration' => 'integer',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(related: Category::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(related: Genre::class);
    }
}
