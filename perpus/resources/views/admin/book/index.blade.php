@extends('layouts.admin')

@section('header', 'Book')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endsection

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-5 offset-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" name="search" class="form-control" autocomplete="off"
                        placeholder="Search for title" v-model="search">
                </div>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" @click="addData()"><i class="fas fa-plus"></i> Create new book</button>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-sm-3" v-for="book in filteredList">
                <div class="card" v-on:click="editData(book)">
                    <div class="card-header">
                        <h3 class="card-title">@{{ book.title }} (@{{ book.qty }})</h3>
                    </div>
                    <div class="card-body">
                        Rp.@{{ numberWithSpaces(book.price) }},-
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="url" method="post" @submit="submitForm($event, book.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Book</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                                <label>ISBN</label>
                                <input type="number" name="isbn" :value="book.isbn" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" :value="book.title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Year</label>
                                <input type="number" name="year" :value="book.year" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Publisher</label>
                                <select name="publisher_id" :value="book.publisher_id" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($publishers as $publisher)
                                        <option :selected="book.publisher_id == {{ $publisher->id }}"
                                            value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Author</label>
                                <select name="author_id" :value="book.author_id" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($authors as $author)
                                        <option :selected="book.author_id == {{ $author->id }}"
                                            value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Catalog</label>
                                <select name="catalog_id" :value="book.catalog_id" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($catalogs as $catalog)
                                        <option :selected="book.catalog_id == {{ $catalog->id }}"
                                            value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="number" name="qty" :value="book.qty" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" :value="book.price" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" @click="deleteData($event, book.id)"
                                v-if="editStatus">Delete</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')

    <script src="{{ asset('assets') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        var url = '{{ url('books') }}';
        var apiurl = '{{ url('api/books') }}';

        var app = new Vue({
            el: '#controller',
            data: {
                books: [],
                search: '',
                book: {},
                url,
                apiurl,
                editStatus: false
            },
            mounted: function() {
                this.getbooks()
            },
            methods: {
                getbooks() {
                    const _this = this;
                    $.ajax({
                        url: apiurl,
                        method: 'get',
                        success: function(data) {
                            _this.books = JSON.parse(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
                addData() {
                    this.book = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(book) {
                    this.book = book;
                    this.editStatus = true;

                    $('#modal-default').modal(book);
                },
                deleteData(event, id) {
                    this.editStatus = true;
                    if (confirm('Are you sure delete this data?')) {
                        event.preventDefault();
                        axios.post(this.url + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully delete!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            this.getbooks();
                        });
                    }
                    $('#modal-default').modal('hide');

                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var url = !this.editStatus ? this.url : this.url + '/' + id;
                    axios.post(url, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        this.getbooks();

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

                },
                numberWithSpaces(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            },
            computed: {
                filteredList() {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().includes(this.search.toLowerCase())
                    })
                }
            }
        });
    </script>
@endsection
