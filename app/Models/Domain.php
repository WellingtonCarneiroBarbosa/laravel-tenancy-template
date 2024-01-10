<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Domain as TenancyDomainModel;

/**
 * App\Models\Domain
 *
 * @property int $id
 * @property string $domain
 * @property string $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Domain extends TenancyDomainModel
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'central';
}
