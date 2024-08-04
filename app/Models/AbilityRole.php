<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbilityRole extends Model
{
    use HasFactory;


    protected $table = 'ability_role';

    public $timestamps = true;


    protected $fillable = [
        'role_id',
        'ability_id'
    ];
    public function role()
    {
        return $this->belongsTo(Role::class,  'role_id');
    }
    public function ability(): BelongsTo
    {
        return $this->belongsTo(Abilities::class, 'ability_id');
    }
}
