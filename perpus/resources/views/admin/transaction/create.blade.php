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

                        <form action="{{ url('transactions') }}" method="POST">
                            @csrf

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Member</label>
                                    <select name="member_id" class="form-control" required>
                                        <option value=""></option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="date_start"
                                        class="form-control @error('date_start') is-invalid @enderror" autocomplete="off"
                                        required>
                                    @error('date_start')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kembali</label>
                                    <input type="date" name="date_end"
                                        class="form-control @error('date_end') is-invalid @enderror" autocomplete="off"
                                        required>
                                    @error('date_end')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="book_id">Books</label>
                                    <select class="select2 form-control" name="book_id[]" id="book_id" multiple="multiple"
                                        required>
                                        <option value=""></option>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                                        @endforeach
                                    </select>
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
            $('#book_id').select2({
                theme: "classic"
            });
        });
    </script>
@endsection
