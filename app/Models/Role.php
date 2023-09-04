<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'user_role';

    protected $fillable = [
        'user_id',
        'role_id'
    ];
}
