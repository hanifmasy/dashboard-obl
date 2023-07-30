<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocObl extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'form_obl as obl';
}
