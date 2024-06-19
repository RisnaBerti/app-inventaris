<div class="row mb-2">
    <div class="col-md-12">
        <div class="form-group">
            <label for="transak-id">{{ __('Transak') }}</label>
            <select class="form-select @error('transak_id') is-invalid @enderror" name="transak_id" id="transak-id"
                    class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select transak') }} --</option>
    
                {{-- @foreach ($data as $transak)
                    <option value="{{ $transak->id }}"
                            {{ old('transak_id', $pelaporan->transak_id) == $transak->id ? 'selected' : '' }}>
                        {{ $transak->barang->nama_barang }} - {{ $transak->barang->kode_barang }} - {{ $transak->ruangan->nama_ruangan }} -
                        {{ $transak->tahun_akademik }} - {{ $transak->jml_mutasi }} - {{ $transak->jenis_mutasi }} - {{ date('F/Y', strtotime($transak->periode)) }}
                    </option>
                @endforeach --}}
                @foreach ($data as $transak)
                    <option value="{{ $transak->id }}" {{ old('transak_id', $pelaporan->transak_id ?? '') == $transak->id ? 'selected' : '' }}>
                        {{ $transak->barang->nama_barang }} - {{ $transak->barang->kode_barang }} - {{ $transak->ruangan->nama_ruangan }} - {{ $transak->tahun_akademik }} - {{ $transak->jml_mutasi }} - {{ $transak->jenis_mutasi }} - {{ date('F/Y', strtotime($transak->periode)) }}
                    </option>
                @endforeach
            </select>
            @error('transak_id')
            <span class="text-danger">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="no-inventari">{{ __('No Inventaris') }}</label>
            <input type="text" name="no_inventaris" id="no-inventari"
                class="form-control @error('no_inventaris') is-invalid @enderror"
                value="{{ isset($pelaporan) ? $pelaporan->no_inventaris : old('no_inventaris') }}"
                placeholder="{{ __('No Inventaris') }}" required />
            @error('no_inventaris')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jml-baik">{{ __('Jml Baik') }}</label>
            <input type="number" name="jml_baik" id="jml-baik"
                class="form-control @error('jml_baik') is-invalid @enderror"
                value="{{ isset($pelaporan) ? $pelaporan->jml_baik : old('jml_baik') }}"
                placeholder="{{ __('Jml Baik') }}" />
            @error('jml_baik')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jml-kurang-baik">{{ __('Jml Kurang Baik') }}</label>
            <input type="number" name="jml_kurang_baik" id="jml-kurang-baik"
                class="form-control @error('jml_kurang_baik') is-invalid @enderror"
                value="{{ isset($pelaporan) ? $pelaporan->jml_kurang_baik : old('jml_kurang_baik') }}"
                placeholder="{{ __('Jml Kurang Baik') }}" />
            @error('jml_kurang_baik')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jml-rusak-berat">{{ __('Jml Rusak Berat') }}</label>
            <input type="number" name="jml_rusak_berat" id="jml-rusak-berat"
                class="form-control @error('jml_rusak_berat') is-invalid @enderror"
                value="{{ isset($pelaporan) ? $pelaporan->jml_rusak_berat : old('jml_rusak_berat') }}"
                placeholder="{{ __('Jml Rusak Berat') }}" />
            @error('jml_rusak_berat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jml-hilang">{{ __('Jml Hilang') }}</label>
            <input type="number" name="jml_hilang" id="jml-hilang"
                class="form-control @error('jml_hilang') is-invalid @enderror"
                value="{{ (isset($pelaporan) ? $pelaporan->jml_hilang : old('jml_hilang')) ? old('jml_hilang') : '1' }}"
                placeholder="{{ __('Jml Hilang') }}" />
            @error('jml_hilang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="keterangan">{{ __('Keterangan') }}</label>
            <input type="text" name="keterangan" id="keterangan"
                class="form-control @error('keterangan') is-invalid @enderror"
                value="{{ isset($pelaporan) ? $pelaporan->keterangan : old('keterangan') }}"
                placeholder="{{ __('Keterangan') }}" />
            @error('keterangan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
