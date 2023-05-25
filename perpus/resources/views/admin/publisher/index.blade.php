@extends('layouts.admin')

@section('header', 'Publisher')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endsection

@section('content')
    <div id="controller">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="#" type="button" class="btn btn-primary mb-2" @click="addData()"><i
                                    class="fas fa-plus"></i> New
                                Publisher</a>
                            @if (session()->has('message'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>

                        <div class="card-body">

                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px" class="text-center">No.</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Phone Number</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Created At</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

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

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="url" method="post" @submit="submitForm($event, data.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Publisher</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" :value="data.name"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" :value="data.email"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_number" :value="data.phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror" required>
                                @error('phone_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" :value="data.address"
                                    class="form-control @error('address') is-invalid @enderror" required>
                                @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script src="{{ asset('assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        var url = '{{ url('publishers') }}';
        var apiUrl = '{{ url('api/publishers') }}';

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: false
            }, {
                data: 'name',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'email',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'phone_number',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'address',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'tanggal',
                class: 'text-center',
                orderable: false
            },
            {
                render: function(index, row, data, meta) {
                    return `
                <a href="#" class="btn btn-primary btn-sm" onclick="controller.editData(event, ${meta.row})"><i class="fas fa-edit"></i> Edit</a>
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})"><i class="fas fa-trash"></i> Delete</a>
            `
                },
                orderable: false,
                width: '200px',
                class: 'text-center'
            },
        ];
    </script>
    <script src="{{ asset('js/data.js') }}"></script>

    {{-- <script>
        $(function() {
            $("#example1").DataTable({

            })
        });
    </script>


    <script>
        var controller = new Vue({
            el: '#controller',
            data: {
                data: {},
                url: '{{ url('publishers') }}',
                editStatus: false
            },
            mounted: function() {

            },
            methods: {
                addData() {
                    this.data = {};
                    this.url = '{{ url('publishers') }}';
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(data) {
                    this.data = data;
                    this.url = '{{ url('publishers') }}' + '/' + data.id;
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(id) {
                    this.url = '{{ url('publishers') }}' + '/' + id;
                    if (confirm('Are you sure delete this data?')) {
                        axios.post(this.url, {
                            _method: 'DELETE'
                        }).then(response => {
                            alert('Data succesfully delete');
                            location.reload();
                        });
                    }
                }
            }
        })
    </script> --}}
@endsection
