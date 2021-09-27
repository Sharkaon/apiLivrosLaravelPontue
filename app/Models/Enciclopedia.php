<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enciclopedia extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'enciclopedias';
    protected $fillable = ['edicao', 'editora', 'data_publi'];
}
