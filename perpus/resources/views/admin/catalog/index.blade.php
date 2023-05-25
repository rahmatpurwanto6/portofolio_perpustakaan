@extends('layouts.admin')

@section('header', 'Catalog')

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ url('catalogs/create') }}" type="button" class="btn btn-primary mb-2"><i
                                class="fas fa-plus"></i> New
                            Catalog</a>
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px" class="text-center">No.</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Total Books</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catalogs as $key => $catalog)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 . '.' }}</td>
                                        <td>{{ $catalog->name }}</td>
                                        <td class="text-center">{{ count($catalog->books) }}</td>
                                        <td class="text-center">{{ tanggal_helper($catalog->created_at) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('catalogs/' . $catalog->id . '/edit') }}"
                                                class="btn btn-primary btn-sm mb-1"><i class="fas fa-edit"></i>
                                                Edit</a>
                                            <form action="{{ url('catalogs', ['id' => $catalog->id]) }}" method="post">
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure delete this data?')"><i
                                                        class="fas fa-trash"></i>
                                                    Delete</button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
