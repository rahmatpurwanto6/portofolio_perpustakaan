<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['isbn', 'title', 'year', 'publisher_id', 'author_id', 'catalog_id', 'qty', 'price'];

    public function publisher()
    {
        return $this->belongsTo('App\Models\Publisher', 'publisher_id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\Author', 'author.id');
    }

    public function catalog()
    {
        return $this->belongsTo('App\Models\Catalog', 'catalog.id');
    }
    //relasi buku ke transaksi details
    public function book()
    {
        return $this->hasMany('App\Models\TransactionDetail', 'book_id');
    }

    public function book_count()
    {
        $books = DB::table('books')->count();
        return $books;
    }

    public function donat_data()
    {
        $donat = DB::table('books')->select(DB::raw("COUNT(publisher_id) as total"))->groupBy('publisher_id')->orderBy('publisher_id', 'asc')->pluck('total');
        return $donat;
    }

    public function line_data()
    {
        $line = DB::table('books')->select(DB::raw("COUNT(author_id) as total"))->groupBy('author_id')->orderBy('author_id', 'asc')->pluck('total');
        return $line;
    }
}
