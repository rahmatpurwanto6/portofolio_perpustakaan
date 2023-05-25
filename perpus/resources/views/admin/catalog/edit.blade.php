@extends('layouts.admin')

@section('header', 'Catalog')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Catalog</h3>
                    </div>

                    <form action="{{ url('catalogs/' . $catalog->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter new name"
                                    autocomplete="off" value="{{ $catalog->name }}">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i>
                                Submit</button>
                            <a href="{{ url('catalogs') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>
                                Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
