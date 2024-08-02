<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbilityUser extends Model
{
  use HasFactory;


  protected $table = 'ability_user';

  protected $fillable = [
    'user_id',
    'ability_id'
  ];

  public $timestamps = true;


  public function ability(): BelongsTo
  {
    return $this->belongsTo(Abilities::class, 'ability_id');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
