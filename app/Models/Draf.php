<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Draf extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'form_obl';
}
