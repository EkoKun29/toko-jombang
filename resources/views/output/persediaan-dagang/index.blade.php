@extends('layouts.app')
@section('title')
    Persediaan Dagang
@stop
@section('content')
    <div class="card-body">
        <table class="table table-bordered table-hover bg-white" id="myTable">
            <thead>
                <tr>
                    <th class="text-center" width="5%">#</th>
                    <th width="30%">Nama Barang & Lot</th>
                    <th>Nama Barang</th>
                    <th>No Lot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item->nama_barang_dan_no_lot }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->no_lot }}</td>
                        <td>
                            <a href="{{ route('persediaan.delete', $item['id']) }}"
                                onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data {{ $item->nama_barang }}')"
                                value="Delete" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@push('js')
    <script>
        let table = new DataTable('#myTable', {
            searchable: true,
            fixedHeight: true
        });
    </script>
@endpush
