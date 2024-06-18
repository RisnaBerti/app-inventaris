<td>
    @can('ruangan view')
        <a href="{{ route('ruangans.show', $model->id) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

    @can('ruangan edit')
        <a href="{{ route('ruangans.edit', $model->id) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('ruangan delete')
        <form action="{{ route('ruangans.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Anda yakin untuk menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
