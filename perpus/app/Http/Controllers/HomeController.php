<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $books, $members, $publishers, $trans, $authors;

    public function __construct()
    {
        $this->middleware('auth');
        $this->books = new Book();
        $this->members = new Member();
        $this->publishers = new Publisher();
        $this->trans = new Transaction();
        $this->authors = new Author();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role('petugas')) {

            $total_book = $this->books->book_count();
            $total_member = $this->members->member_count();
            $total_publisher = $this->publishers->publisher_count();
            $total_pinjam = $this->trans->trans_count();

            $data_donat = $this->books->donat_data();
            $label_donat = $this->publishers->publisher_label();

            $data_line = $this->books->line_data();
            $label_line = $this->authors->author_label();

            $label_bar = ['Peminjaman', 'Pengembalian'];
            $data_bar = [];

            foreach ($label_bar as $key => $value) {
                $data_bar[$key]['label'] = $label_bar[$key];
                $data_bar[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,188,0.9)' : 'rgba(210,214,222,1)';
                $data_month = [];

                foreach (range(1, 12) as $month) {
                    if ($key == 0) {
                        $data_month[] = Transaction::select(DB::raw("COUNT(status) as total"))->where('status', 1)->whereMonth('date_start', $month)->first()->total;
                    } else {
                        $data_month[] = Transaction::select(DB::raw("COUNT(status) as total"))->where('status', 2)->whereMonth('date_end', $month)->first()->total;
                    }
                }
                $data_bar[$key]['data'] = $data_month;
            }

            return view('home', compact('total_book', 'total_member', 'total_publisher', 'total_pinjam', 'data_donat', 'label_donat', 'data_bar', 'data_line', 'label_line'));
        } else {
            return abort(403);
        }
    }

    public function test_spatie()
    {
        // $role = Role::create(['name' => 'petugas']);
        // $permission = Permission::create(['name' => 'index peminjaman']);

        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // $user = auth()->user();
        // $user->assignRole('petugas');
        // return $user;

        // $user = User::with('roles')->get();
        // return $user;

        // $user = auth()->user();
        // $user->removeRole('petugas');
        // return $user;
    }
}
