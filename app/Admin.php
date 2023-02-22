<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Admin extends Authenticatable
{
    
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'name','username', 'email', 'password'
    ];

}
