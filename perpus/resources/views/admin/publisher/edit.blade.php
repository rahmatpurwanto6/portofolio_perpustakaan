@extends('layouts.admin')

@section('header', 'Publisher')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Publisher</h3>
                    </div>

                    <form action="{{ route('publishers.update', $publisher->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name"
                                    autocomplete="off" value="{{ $publisher->name }}">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email"
                                    autocomplete="off" value="{{ $publisher->email }}">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    placeholder="Enter Phone Number" autocomplete="off"
                                    value="{{ $publisher->phone_number }}">
                                @error('phone_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address"
                                    autocomplete="off" value="{{ $publisher->address }}">
                                @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i>
                                Submit</button>
                            <a href="{{ route('publishers.index') }}" class="btn btn-default"><i
                                    class="fas fa-arrow-left"></i>
                                Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
