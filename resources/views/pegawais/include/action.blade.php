<td>
    @can('pegawai view')
        <a href="{{ route('pegawais.show', $pegawais->pegawai_id) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

    @can('pegawai edit')
        <a href="{{ route('pegawais.edit', $pegawais->pegawai_id) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('pegawai delete')
        <form action="{{ route('pegawais.destroy', $pegawais->pegawai_id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
