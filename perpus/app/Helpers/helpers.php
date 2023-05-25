<?php

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

function tanggal_helper($value)
{
    $tanggal = date($value);

    switch (date('m', strtotime($tanggal))) {
        case '01':
            $bulan = 'Januari';
            break;
        case '02':
            $bulan = 'Februari';
            break;
        case '03':
            $bulan = 'Maret';
            break;
        case '04':
            $bulan = 'April';
            break;
        case '05':
            $bulan = 'Mei';
            break;
        case '06':
            $bulan = 'Juni';
            break;
        case '07':
            $bulan = 'Juli';
            break;
        case '08':
            $bulan = 'Agustus';
            break;
        case '09':
            $bulan = 'September';
            break;
        case '10':
            $bulan = 'Oktober';
            break;
        case '11':
            $bulan = 'November';
            break;
        case '12':
            $bulan = 'Desember';
            break;

        default:
            $bulan = 'Tidak diketahui';
            break;
    }

    return date('d', strtotime($tanggal)) . ' ' . $bulan . ' ' . date('Y', strtotime($tanggal));
}

function getNotif_helper()
{
    $data =  DB::table('transactions')
        ->where('status', 1)
        ->where('date_end', '<', now())->count();

    return $data;
}

function data_notif()
{
    // $trans = Transaction::select(
    //     'transactions.date_end as tanggal_kembali',
    //     'transactions.status',
    //     'members.name'
    // )
    //     ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
    //     ->join('members', 'members.id', '=', 'transactions.member_id')
    //     ->orderBy('transactions.id', 'DESC')
    //     ->groupBy('transactions.id')
    //     ->where('transactions.status', 1)->get();
    $trans = DB::table('transactions')
        ->select('members.name', DB::raw('DATEDIFF(now(), date_end) as deadline'))
        ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
        ->join('members', 'members.id', '=', 'transactions.member_id')
        ->where('status', 1)
        ->orderBy('transactions.id', 'DESC')
        ->groupBy('transactions.id')
        ->limit(10)
        ->get();

    $data = $trans;
    foreach ($data as $row) {
        echo '<i class="fas fa-user"></i> ' . $row->name . '<span class="float-right text-sm text-danger">melewati batas waktu ' . $row->deadline . '
            hari</span>
            <div class="dropdown-divider"></div>
            <br>';
    }
}
