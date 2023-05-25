@extends('layouts.admin')

@section('header', 'Transaction')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection

@section('content')
    <div class="controller">

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detail Transaction</h3>
                        </div>

                        <form action="#" method="POST">
                            @csrf
                            {{ method_field('PUT') }}

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Member</label>
                                    @foreach ($members as $data)
                                        <input type="text" name="member_id" class="form-control"
                                            value="{{ $data->name }}" readonly>
                                    @endforeach

                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="date_start"
                                        class="form-control @error('date_start') is-invalid @enderror" autocomplete="off"
                                        value="{{ $transaction->date_start }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kembali</label>
                                    <input type="date" name="date_end"
                                        class="form-control @error('date_end') is-invalid @enderror" autocomplete="off"
                                        value="{{ $transaction->date_end }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="book_id">Books</label>
                                    @foreach ($books as $book)
                                        <input type="text" name="book_id[]" id="book_id[]" class="form-control" readonly
                                            value="{{ $book->title }}">
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" name="status" class="form-control"
                                        value="{{ $transaction->status == 2 ? 'Sudah dikembalikan' : 'Belum dikembalikan' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="card-footer">
                                {{-- <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i>
                                    Submit</button> --}}
                                <a href="{{ route('transactions.index') }}" class="btn btn-default"><i
                                        class="fas fa-arrow-left"></i>
                                    Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#book_id').select2();
        });
    </script>
@endsection
