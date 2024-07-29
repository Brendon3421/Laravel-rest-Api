<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;


    protected $table = 'ability_role';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'role_id',
        'user_id'
    ];
}
