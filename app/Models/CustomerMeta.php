<?php

namespace App\Models;

use App\Http\Enums\CustomerMetaCodeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerMeta extends Model
{
    use HasFactory;

    /**
     * Because naming conventions are not exactly followed...
     *
     * @var string
     */
    protected $table = 'customer_meta';

    /**
     * @var string[]
     */
    protected $casts = [
        'code' => CustomerMetaCodeEnum::class
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
