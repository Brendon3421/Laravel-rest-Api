<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Abilities extends Model
{
    use HasFactory;

    protected $table = 'abilities';  

    protected $fillable = [
        'name',
    ];

    public $timestamps = true;


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
