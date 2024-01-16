<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected $casts = [
        'steps'     => 'array',
        'questions' => 'array',
    ];

    public function questions(): Attribute
    {
        return Attribute::make(
            set: function (array $value) {
                foreach ($value as $key => $questions) {
                    foreach ($questions['questions'] as $questionKey => $question) {
                        $question['input_name'] = str_replace(
                            '-',
                            '_',
                            preg_replace(
                                '/[^A-Za-z0-9\-]/',
                                '',
                                Str::slug($question['title'])
                            )
                        );

                        $value[$key]['questions'][$questionKey] = $question;
                    }
                }

                return collect($value);
            }
        );
    }
}
