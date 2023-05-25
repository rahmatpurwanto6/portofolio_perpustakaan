<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.transaction.index');
    }

    public function api(Request $request)
    {
        if ($request->status) {
            $trans = Transaction::select(
                'transactions.id',
                'transactions.date_start as tanggal_pinjam',
                'transactions.date_end as tanggal_kembali',
                'transactions.status',
                'books.id as id_book',
                'books.title',
                'books.qty as stok',
                'books.price as harga',
                'members.id as id_member',
                'members.name',

                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) as lama_pinjam'),
                DB::raw('COUNT(transaction_details.book_id) as total_buku'),
                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) * books.price * COUNT(transaction_details.book_id) as total_bayar')
            )
                ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->join('books', 'books.id', '=', 'transaction_details.book_id')
                ->join('members', 'members.id', '=', 'transactions.member_id')
                ->orderBy('transactions.id', 'DESC')
                ->groupBy('transactions.id')
                ->where('transactions.status', '=', $request->status)->get();
        } else {
            $trans = Transaction::select(
                'transactions.id',
                'transactions.date_start as tanggal_pinjam',
                'transactions.date_end as tanggal_kembali',
                'transactions.status',
                'books.id as id_book',
                'books.qty as stok',
                'books.price as harga',
                'members.id as id_member',
                'members.name',

                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) as lama_pinjam'),
                DB::raw('COUNT(transaction_details.book_id) as total_buku'),
                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) * books.price * COUNT(transaction_details.book_id) as total_bayar')
            )
                ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->join('books', 'books.id', '=', 'transaction_details.book_id')
                ->join('members', 'members.id', '=', 'transactions.member_id')
                ->orderBy('transactions.id', 'DESC')
                ->groupBy('transactions.id')->get();
        }

        $datatables = datatables()->of($trans)
            ->addColumn('status', function ($trans) {
                if ($trans->status == 2) {
                    return 'Sudah dikembalikan';
                } else {
                    return 'Belum dikembalikan';
                }
            })
            ->addColumn('tanggal_pinjam', function ($trans) {
                return tanggal_helper($trans->tanggal_pinjam);
            })
            ->addColumn('tanggal_kembali', function ($trans) {
                return tanggal_helper($trans->tanggal_kembali);
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }

    public function cari_tanggal(Request $request)
    {
        if ($request->pinjam) {
            $trans = Transaction::select(
                'transactions.date_start as tanggal_pinjam',
                'transactions.date_end as tanggal_kembali',
                'transactions.status',
                'books.qty as stok',
                'books.price as harga',
                'members.name',

                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) as lama_pinjam'),
                DB::raw('COUNT(transaction_details.book_id) as total_buku'),
                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) * books.price * COUNT(transaction_details.book_id) as total_bayar')
            )
                ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->join('books', 'books.id', '=', 'transaction_details.book_id')
                ->join('members', 'members.id', '=', 'transactions.member_id')
                ->orderBy('transactions.id', 'DESC')
                ->groupBy('transactions.id')
                ->where('transactions.date_start', '=', $request->pinjam)->get();
        } else {
            $trans = Transaction::select(
                'transactions.date_start as tanggal_pinjam',
                'transactions.date_end as tanggal_kembali',
                'transactions.status',
                'books.qty as stok',
                'books.price as harga',
                'members.name',

                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) as lama_pinjam'),
                DB::raw('COUNT(transaction_details.book_id) as total_buku'),
                DB::raw('DATEDIFF(transactions.date_end, transactions.date_start) * books.price * COUNT(transaction_details.book_id) as total_bayar')
            )
                ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
                ->join('books', 'books.id', '=', 'transaction_details.book_id')
                ->join('members', 'members.id', '=', 'transactions.member_id')
                ->orderBy('transactions.id', 'DESC')
                ->groupBy('transactions.id')->get();
        }

        $datatables = datatables()->of($trans)
            ->addColumn('status', function ($trans) {
                if ($trans->status == 2) {
                    return 'Sudah dikembalikan';
                } else {
                    return 'Belum dikembalikan';
                }
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::all();
        $books = DB::table('books')->where('qty', '>', 0)->get();
        return view('admin.transaction.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id'      => 'required',
            'date_start'     => 'required',
            'date_end'     => 'required',
            'book_id'   => 'required'
        ]);

        $transaction = new Transaction();

        $transaction->member_id = $request->member_id;
        $transaction->date_start = $request->date_start;
        $transaction->date_end = $request->date_end;
        $transaction->status = 1;
        $transaction->save();

        $book = $request->input('book_id');


        foreach ($book as $row) {
            DB::table('transaction_details')->insert([
                'transaction_id' => $transaction->id,
                'book_id' =>  $row,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('books')
                ->where('id', $row)
                ->decrement('qty', 1);
        }


        session()->flash('message', 'Data succesfully submit');
        return redirect('transactions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $members = Member::select('name')->where('members.id', $transaction->member_id)->get();
        $books = DB::table('books')->select('books.title')
            ->join('transaction_details', 'transaction_details.book_id', '=', 'books.id')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->where('transactions.member_id', $transaction->member_id)
            ->get();

        return view('admin.transaction.show', compact('transaction', 'members', 'books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $members = Member::all();
        $books = DB::table('books')->where('qty', '>', 0)->get();

        return view('admin.transaction.edit', compact('transaction', 'members', 'books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'member_id'      => 'required',
            'date_start'     => 'required',
            'date_end'     => 'required',
            'book_id'   => 'required'
        ]);

        // $transaction->member_id = $request->member_id;
        // $transaction->date_start = $request->date_start;
        // $transaction->date_end = $request->date_end;
        // $transaction->status = $request->status;
        // $transaction->update();

        DB::table('transactions')
            ->where('id', $transaction->id)
            ->update([
                'member_id' =>  $request->member_id,
                'date_start' =>  $request->date_start,
                'date_end' =>  $request->date_end,
                'status' =>  $request->status,
            ]);

        $book = $request->input('book_id');

        foreach ($book as $row) {
            $transaction = new Transaction();
            DB::table('transaction_details')
                ->where('transaction_id', $transaction->id)
                ->update([
                    'book_id' =>  $row
                ]);

            DB::table('books')
                ->where('id', $row)
                ->increment('qty', 1);
        }


        session()->flash('message', 'Data succesfully update');
        return redirect('transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        session()->flash('message', 'Data succesfully delete');
        return redirect('transactions');
    }
}
