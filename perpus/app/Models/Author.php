<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number', 'address'];

    public function books()
    {
        return $this->hasMany('App\Models\Book', 'author_id');
    }

    public function author_label()
    {
        $label = DB::table('authors')->orderBy('authors.id', 'asc')->join('books', 'books.author_id', '=', 'authors.id')->groupBy('name')->pluck('name');
        return $label;
    }
}
