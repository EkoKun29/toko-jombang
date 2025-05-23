@extends('layouts.app')
@section('title')
Pembelian NA Hutang
@stop
@section('content')
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm d-block my-2 ml-auto" data-toggle="modal"
            data-target="#createModal">
            Tambah
        </button>
        @include('in.pembelian-na.create')
        <x-alert />
        <table id="tbl_pembelian_na" class="table table-bordered table-hover bg-white">
            <thead>
                <tr>
                    <th>Nomor Nota</th>
                    <th>Tanggal</th>
                    <th>Sales</th>
                    <th>Dibawa Oleh</th>
                    <th>Supplier</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Hutang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('in.pembelian-na.delete')
    @include('in.pembelian-na.edit')
@stop
@push('js')
    <script>
        new TomSelect("#select-supplier", {
            create: false,
        });
        new TomSelect("#select-barang", {
            create: false,
        });
    </script>
    <script>
        // MENAMPILKAN TABLE
        $table_data = $('#tbl_pembelian_na').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pembelian-na.show') }}",
            columns: [{
                    data: 'no_nota',
                    name: 'no_nota'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'atas_nama_sales',
                    name: 'atas_nama_sales'
                },
                {
                    data: 'yang_bawa_barang',
                    name: 'yang_bawa_barang'
                },
                {
                    data: 'nama_suplier',
                    name: 'nama_suplier'
                },
                {
                    data: 'nama_barang',
                    name: 'nama_barang'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'hutang',
                    name: 'hutang'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

        // FUNGSI UNTUK MELAKUKAN DELETE
        let _id = '';

        function openModal($id) {
            _id = $id;
            $('#namaData').html($id);
            $('#deleteModal').modal();
        }

        $('#deleteModalForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'delete',
                url: `/pembelian-na/${_id}`,
            }).done(function(data) {
                $('#deleteModal').modal('hide');
                $table_data.ajax.reload();
            }).fail(function(data) {
                $('#deleteModal').modal('hide');
                alert('Kesalahan pada website. Hubungi IT!');
            });
        });

        // FUNGSI UNTUK MELAKUKAN EDIT
        function editModal($id) {
            _id = $id;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: `/pembelian-na/edit/${_id}`,
            }).done(function(data) {
                $('#editModal').modal();
                $('#editForm').attr('action', `pembelian-na/update/${_id}`);
                $('input[name="no_nota"]').val(data.data.no_nota);
                $('input[name="tanggal"]').val(data.data.tanggal);
                $('input[name="nama_suplier"]').val(data.data.nama_suplier);
                $('input[name="no_lot"]').val(data.data.no_lot);
                $('input[name="harga"]').val(data.data.harga);
                $('input[name="qty"]').val(data.data.qty);
                $('input[name="hutang"]').val(data.data.hutang);
                $('select[name="nama_barang"]').val(data.data.nama_barang).trigger('change');
            }).fail(function(data) {
                alert('Kesalahan pada website. Hubungi IT!');
            });
        }
    </script>
@endpush
