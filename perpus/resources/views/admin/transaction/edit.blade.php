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
                            <h3 class="card-title">Transaction</h3>
                        </div>

                        <form action="{{ url('transactions/' . $transaction->id) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Member</label>
                                    <select name="member_id" class="form-control" value="{{ $transaction->name }}" required>
                                        <option value=""></option>
                                        @foreach ($members as $member)
                                            <option {{ $member->id == $transaction->member_id ? 'selected' : '' }}
                                                value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="date_start"
                                        class="form-control @error('date_start') is-invalid @enderror" autocomplete="off"
                                        value="{{ $transaction->date_start }}" required>
                                    @error('date_start')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kembali</label>
                                    <input type="date" name="date_end"
                                        class="form-control @error('date_end') is-invalid @enderror" autocomplete="off"
                                        value="{{ $transaction->date_end }}" required>
                                    @error('date_end')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="book_id">Books</label>
                                    <select class="select2 form-control" name="book_id[]" id="book_id" multiple="multiple"
                                        required>
                                        @foreach ($books as $book)
                                            <option @if (in_array(
                                                    $book->id,
                                                    \App\Models\TransactionDetail::query()->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')->where('transactions.member_id', $transaction->member_id)->pluck('book_id')->toArray())) selected @endif
                                                value="{{ $book->id }}">{{ $book->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio1" name="status"
                                            value="2">
                                        <label class="form-check-label" for="radio1">Sudah dikembalikan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="radio2" name="status"
                                            value="1">
                                        <label class="form-check-label" for="radio2">Belum dikembalikan</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i>
                                    Submit</button>
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

        // document.forms['form'].elements['status'].value = '{{ $transaction->status }}'
    </script>
@endsection
