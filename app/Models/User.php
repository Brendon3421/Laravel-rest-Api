<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'genero_id',
        'situacao_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $attributes = [
        'situacao_id' => 1,
    ];

    public function situacao()
    {
        return $this->belongsTo(Situacao::class);
    }

    public function genero(): BelongsTo
    {
        return $this->belongsTo(Genero::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class);
    }

    public function roleAbilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('name');
    }

    public function allAbilities()
    {
        return $this->roleAbilities()->merge($this->abilities->pluck('name'))->unique();
    }
}
