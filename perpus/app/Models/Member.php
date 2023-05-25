<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'phone_number', 'email', 'address'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'member_id');
    }

    public function trans()
    {
        return $this->hasOne('App\Models\Transaction', 'member_id');
    }

    public function member_count()
    {
        $members = DB::table('members')->count();
        return $members;
    }
}
