<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'book_id'];

    public function trans_detail()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction.id');
    }

    public function detail()
    {
        return $this->belongsToMany('App\Models\Book', 'book.id');
    }
}
