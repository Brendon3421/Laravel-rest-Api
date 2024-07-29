<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbilityUser extends Model
{
    use HasFactory;

    
  protected $table = 'ability_user';  

  protected $fillable = [
      'name',
      'user_id',
      'ability_id'
  ];

  public $timestamps = true;



}
