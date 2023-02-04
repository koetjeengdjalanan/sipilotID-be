<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FormQuestion
 *
 * @property string $id
 * @property string|null $form_id
 * @property int $order
 * @property string $question
 * @property string $type
 * @property mixed|null $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Submission[] $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Form|null $form
 * @method static \Database\Factories\FormQuestionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FormQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FormQuestion extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType   = 'string';

    protected $guarded = [
        'created_at',
    ];
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
