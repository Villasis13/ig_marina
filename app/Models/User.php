<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

// The User model requires this trait
class User extends Authenticatable
{
    private  $log;
    public function __construct()
    {
        $this->log = new Logs();
    }
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users";
    protected $primaryKey = "id_users";
    protected $fillable = [
        'nombre_users',
        'email',
        'password',
        'username',
        'users_fotografia',
        'id_persona',
        'users_estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public  function listar_usuarios(){
        try {
            $result = DB::table('users as u')->join('persona as p','p.id_persona','=','u.id_persona')
                ->leftJoin('model_has_roles as mr','mr.model_id','=','u.id_users')
                ->leftJoin('roles as r','r.id','=','mr.role_id')
                ->get();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }
    public  function guardar_usuario($persona){
        try {
            $guardar_usuario = new User();
            $guardar_usuario->fill($persona);
            $guardar_usuario->save();
            return $guardar_usuario;
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }


    public  function listar_datos_usuario($id){
        try {
            $result = DB::table('users as u')->join('persona as p','p.id_persona','=','u.id_persona')
                ->join('model_has_roles as mr','mr.model_id','=','u.id_users')
                ->join('roles as r','r.id','=','mr.role_id')
                ->where('u.id_users','=',$id)
                ->first();
        }catch  (\Exception $e){
            $this->log->insertarLog($e);
            $result = [];
        }
        return $result;
    }


}
