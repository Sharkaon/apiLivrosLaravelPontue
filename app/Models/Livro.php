<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'livros';
    protected $fillable = ['titulo', 'autor'];
    protected $nullable = ['editora', 'data_publi'];
}