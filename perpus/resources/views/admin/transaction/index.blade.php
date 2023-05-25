@extends('layouts.admin')

@section('header', 'Transaction')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection

@section('content')
    <div id="controller">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8 mt-4">
                                    <a href="{{ route('transactions.create') }}" type="button"
                                        class="btn btn-primary mb-2"><i class="fas fa-plus"></i> New
                                        Transactions</a>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Select Status</label>
                                        <select class="form-control" name="status">
                                            <option value="0">-</option>
                                            <option value="2">Sudah dikembalikan</option>
                                            <option value="1">Belum dikembalikan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tanggal Pinjam</label>
                                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">

                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px" class="text-center">No.</th>
                                        <th class="text-center">Tanggal Pinjam</th>
                                        <th class="text-center">Tanggal Kembali</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Lama Pinjam(hari)</th>
                                        <th class="text-center">Total Buku</th>
                                        <th class="text-center">Total Bayar</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="url" method="post" @submit="submitForm($event, data.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Transaction</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                                <label>Anggota</label>
                                <select name="member_id" id="member_id" class="form-control" :value="data.id_member"
                                    required>
                                    <option value=""></option>
                                    @foreach ($members as $member)
                                        <option :selected="data.id_member == {{ $member->id }}"
                                            value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pinjam</label>
                                <input type="date" name="date_start" id="date_start" class="form-control"
                                    :value="data.tanggal_pinjam" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Kembali</label>
                                <input type="date" name="date_end" id="date_end" class="form-control"
                                    :value="data.tanggal_kembali" required>
                            </div>
                            <div class="form-group">
                                <label>Buku</label>
                                <select class="select2 form-control" name="book_id[]" id="book_id" multiple="multiple"
                                    required :value="data.title" required>

                                    @foreach ($books as $book)
                                        <option :selected="data.id_book == {{ $book->id }}"
                                            value="{{ $book->id }}">
                                            {{ $book->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" v-if="editStatus">
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
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>

        </div> --}}

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
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        var url = '{{ url('transactions') }}';
        var apiUrl = '{{ url('api/transactions') }}';
        var apicari = '{{ url('cari_tanggal/transactions') }}';

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: false
            },
            // {
            //     data: 'id', // kolom baru dengan data ID
            //     visible: false, // kolom tidak terlihat di tabel
            //     searchable: false // kolom tidak dapat dicari
            // },
            {
                data: 'tanggal_pinjam',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'tanggal_kembali',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'name',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'lama_pinjam',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'total_buku',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'total_bayar',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'status',
                class: 'text-center',
                orderable: false
            },
            {
                render: function(index, row, data, meta) {
                    return `
                <a href="{{ url('transactions/${data.id}/edit') }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> </a>
                <a href="{{ url('transactions/${data.id}') }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> </a>
                <a onclick="controller.deleteData(event, ${data.id})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </a>
            `
                },
                orderable: false,
                width: '200px',
                class: 'text-center'
            },
        ];

        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [], //untuk menampung data dari controller
                data: {}, //untuk crud
                url,
                apiUrl,
                editStatus: false,
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#example1').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET'
                        },
                        columns: columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                    this.editStatus = false;
                    this.datas = '';
                    $('#modal-default').modal();
                },
                editData(event, row, data) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm('Are you sure delete this data?')) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.url + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            // alert('Data succesfully delete');
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully delete!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            this.table.ajax.reload();
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var url = !this.editStatus ? this.url : this.url + '/' + id;
                    axios.post(url, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        _this.table.ajax.reload();

                        if (this.editStatus == false) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully submitted!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully update!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            }
        });

        $('select[name=status]').on('change', function() {
            status = $('select[name=status]').val();

            if (status == 0) {
                controller.table.ajax.url(apiUrl).load();
            } else {
                controller.table.ajax.url(apiUrl + '?status=' + status).load();
            }
        });

        $('#tanggal_pinjam').on('change', function() {
            let pinjam = $('#tanggal_pinjam').val();

            if (pinjam == '') {
                controller.table.ajax.url(apicari).load();
            } else {
                controller.table.ajax.url(apicari + '?pinjam=' + pinjam).load();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#book_id').select2();
        });
    </script>

@endsection
