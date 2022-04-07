<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile_number',
        'country_code',
        'address',
        'lat',
        'long',
        'device_token',
        'device_type',
        'is_email_verified',
        'is_mobile_no_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_no_verified_at' => 'datetime',

    ];
    public function verifyUser() {
		return $this->hasOne('App\Models\VerifyUser');
	}

	/*send notification to mail id */
	public function sendPasswordResetNotification($token) {
		$this->notify(new PasswordResetNotification($token));
	}
}
