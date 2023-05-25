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
            })
        }
    }
});