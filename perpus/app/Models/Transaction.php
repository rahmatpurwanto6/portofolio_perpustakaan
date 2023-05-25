<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'date_start', 'date_end', 'status'];

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member.id');
    }

    public function trans2()
    {
        return $this->hasMany('App\Models\TransactionDetail', 'transaction_id');
    }

    public function trans_count()
    {
        $trans = DB::table('transactions')->whereMonth('created_at', date('m'))->count();
        return $trans;
    }
}
