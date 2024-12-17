<div class="modal fade" id="editModal-{{ $item->id }}" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('audit1.update', $item) }}" method="post">
                    @csrf
                    @method('put')
                    @include('components.select', [
                        'label' => 'Nama Barang',
                        'name' => 'nama_barang',
                        '_data' => $barang,
                        '_item' => 'nama',
                        'isArray' => 'Yes',
                        'selected' => $item->nama_barang,
                    ])
                    @include('components.input', [
                        'label' => 'Duz',
                        'name' => 'duz',
                        'type' => 'number',
                        'value' => $item->duz,
                    ])
                    @include('components.input', [
                        'label' => 'Qty',
                        'name' => 'qty',
                        'type' => 'number',
                        'value' => $item->qty,
                    ])
                    @include('components.input', [
                        'label' => 'Penyetok',
                        'name' => 'penyetok',
                        'type' => 'text',
                        'value' => $item->penyetok,
                    ])
                    @include('components.button', ['submit' => 'submit', 'close' => 'close'])
                </form>
            </div>
        </div>
    </div>
</div>
