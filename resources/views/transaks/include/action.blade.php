<td>
    @can('transak view')
        <a href="{{ route('transaks.show', $transak->id_transaksi) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

    @can('transak edit')
        <a href="{{ route('transaks.edit', $transak->id_transaksi) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('transak delete')
        <form action="{{ route('transaks.destroy', $transak->id_transaksi) }}" method="post" class="d-inline"
            onsubmit="return confirm('Anda yakin untuk menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

