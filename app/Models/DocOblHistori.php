<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocOblHistori extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'form_obl_histori as obl_hist';
}
