@extends('layouts.app')
@section('title')
    OPNAME GLOBAL
@stop
@section('content')
    <div class="card-body">
        {{-- <button type="button" class="btn btn-primary btn-sm d-block my-2 ml-auto" data-toggle="modal"
            data-target="#createModal">
            Tambah
        </button>
        @include('stokglobal.create')
        <x-alert /> --}}
        <table id="myTable" class="table table-bordered table-hover bg-white">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Total</th>
                    {{-- <th>Detail</th> --}}
                </tr>
            </thead>
            <?php $no = 1; ?>
            <tbody> 
                @foreach ($opname_global as $index => $item)
                    <tr>
                        <td> {{ $no++}}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->totalAudit->sum('total')}}</td>
                        {{-- <td><div class="d-flex">
                            <a href="{{ route('stokglobal.detail', $item['id'])}}" class="btn btn-warning btn-sm mr-2">Detail Audit</a>
                            <a href="{{ ('stokglobal.detail', $item['id_opname_global']) }}"
                            class="btn btn-success">&nbsp;Detail Barang</a>
                            </div>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- @include('out.kas-keluar-operasional.delete')
    @include('out.kas-keluar-operasional.edit') --}}
@stop
@push('js')
    <script>
        // MENAMPILKAN TABLE
        $table_data = $('#stok_global').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('stokglobal.index') }}",
            columns:[{
                    data: 'no',
                    name: 'nomor'
                },
                {
                    data: 'barang',
                    name: 'barang'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'stok_audit',
                    name: 'stok_audit'
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
            event.preventDefault(); // Prevent the form from submitting via the browser
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'delete',
                url: `/kas-keluar-operasional/${_id}`,
            }).done(function(data) {
                $('#deleteModal').modal('hide');
                $table_data.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil dihapus',
                    showConfirmButton: false,
                    timer: 1000
                })
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
                url: `/kas-keluar-operasional/edit/${_id}`,
            }).done(function(data) {
                $('#editModal').modal();
                $('#editForm').attr('action', `kas-keluar-operasional/update/${_id}`);
                $('input[name="tanggal"]').val(data.data.tanggal);
                $('select[name="keperluan"]').val(data.data.keperluan).trigger('change');
                $('input[name="keterangan"]').val(data.data.keterangan);
                $('input[name="no_nota"]').val(data.data.no_nota);
                $('input[name="nominal"]').val(data.data.nominal);
            }).fail(function(data) {
                alert('Kesalahan pada website. Hubungi IT!');
            });
        }
    </script>
    <script>
        let table = new DataTable('#myTable', {
            searchable: true,
            fixedHeight: true
        });
    </script>
@endpush
