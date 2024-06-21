<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="jenjang-id">{{ __('Jenjang') }}</label>
            <select class="form-select @error('jenjang_id') is-invalid @enderror" name="jenjang_id" id="jenjang-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select jenjang') }} --</option>
                
                        @foreach ($jenjangs as $jenjang)
                            <option value="{{ $jenjang->id }}" {{ isset($ruangan) && $ruangan->jenjang_id == $jenjang->id ? 'selected' : (old('jenjang_id') == $jenjang->id ? 'selected' : '') }}>
                                {{ $jenjang->nama_jenjang }}
                            </option>
                        @endforeach
            </select>
            @error('jenjang_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-ruangan">{{ __('Nama Ruangan') }}</label>
            <input type="text" name="nama_ruangan" id="nama-ruangan"
                class="form-control @error('nama_ruangan') is-invalid @enderror"
                value="{{ isset($ruangan) ? $ruangan->nama_ruangan : old('nama_ruangan') }}"
                placeholder="{{ __('Nama Ruangan') }}" required />
            @error('nama_ruangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
