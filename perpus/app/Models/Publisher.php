<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number', 'address'];

    public function books()
    {
        return $this->hasMany('App\Models\Book', 'publisher_id');
    }

    public function publisher_count()
    {
        $publishers = DB::table('publishers')->count();
        return $publishers;
    }

    public function publisher_label()
    {
        $label = DB::table('publishers')->orderBy('publishers.id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->groupBy('name')->pluck('name');
        return $label;
    }
}
