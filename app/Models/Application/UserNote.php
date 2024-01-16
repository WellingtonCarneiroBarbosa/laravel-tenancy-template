<?php

namespace App\Models\Application;

use App\Models\Application\User as TenantUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Application\UserNote
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNote query()
 * @mixin \Eloquent
 */
class UserNote extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $fillable = [
        'title',
        'description',
        'date',
        'user_id',
        'created_by',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(TenantUser::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
