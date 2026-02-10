<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'paterno',
        'materno',
        'foto',
        'telefono',
        'estado',
        'id_empresa'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function getNombreCompletoAttribute()
    {
        return "{$this->name} {$this->paterno} {$this->materno}";
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function hasRoleNombre(string $nombre): bool
    {
        $empresaId = $this->id_empresa ?? null;
        if (! $empresaId) {
            return false;
        }

        return DB::table('user_role as ur')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->where('ur.empresa_id', $empresaId)
            ->where('ur.user_id', $this->id)
            ->where('r.nombre', $nombre)
            ->exists();
    }

    public function canPantalla(string $routeName): bool
    {
        $empresaId = $this->id_empresa ?? null;
        if (! $empresaId) {
            return false;
        }

        $pantallaId = DB::table('app_pantallas')
            ->where('route_name', $routeName)
            ->where('estado', 1)
            ->value('id');

        if (! $pantallaId) {
            return false;
        }

        return DB::table('role_pantalla as rp')
            ->join('user_role as ur', function ($join) use ($empresaId) {
                $join->on('ur.role_id', '=', 'rp.role_id')
                    ->where('ur.empresa_id', '=', $empresaId);
            })
            ->where('rp.empresa_id', $empresaId)
            ->where('ur.user_id', $this->id)
            ->where('rp.pantalla_id', $pantallaId)
            ->exists();
    }
}
