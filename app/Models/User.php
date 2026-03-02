<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'status',
       'profileable_type', // Polymorphic relation type
       'profileable_id',   // Polymorphic relation ID
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


    public function profileable() {
        return $this->morphTo();
     }

   public function getFirstNameAttribute() {
            if ($this->profileable) {
                return  $this->profileable->first_name;
            }

            return 'N/A';
        }

     public function getMiddleNameAttribute() {
            if ($this->profileable) {
                return  $this->profileable->middle_name;
            }

            return 'N/A';
        }


     public function getLastNameAttribute() {
            if ($this->profileable) {
                return  $this->profileable->last_name;
            }

            return 'N/A';
        }

}
