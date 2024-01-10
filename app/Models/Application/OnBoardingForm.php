<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Application\OnBoardingForm
 *
 * @method static \Database\Factories\Application\OnBoardingFormFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OnBoardingForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnBoardingForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnBoardingForm query()
 * @mixin \Eloquent
 */
class OnBoardingForm extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $table = 'on_boarding_form';
}
