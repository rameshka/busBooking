<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{
    use Notifiable;
	

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'created_at','logedout_at','usertype'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'];
		$this->username = $attributes['username'];
		$this->created_at = '';
		$this->logedout_at = '';
		$this->usertype = $attributes['usertype'];
    }
	 public function getAuthIdentifierName()
	 {
		 return $this->id;
	}

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
	 {
		 
		 return $this->id;
	}

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
	 {
		 return $this->username;
	}

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
	{
    return $this->remember_token;
}

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
public function setRememberToken($value)
{
    $this->remember_token = $value;
}

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
	{
    return 'remember_token';
}
	

}
