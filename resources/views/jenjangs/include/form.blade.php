<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-jenjang">{{ __('Kode Jenjang') }}</label>
            <input type="text" name="kode_jenjang" id="kode-jenjang" class="form-control @error('kode_jenjang') is-invalid @enderror" value="{{ isset($jenjang) ? $jenjang->kode_jenjang : old('kode_jenjang') }}" placeholder="{{ __('Kode Jenjang') }}" required />
            @error('kode_jenjang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-jenjang">{{ __('Nama Jenjang') }}</label>
            <input type="text" name="nama_jenjang" id="nama-jenjang" class="form-control @error('nama_jenjang') is-invalid @enderror" value="{{ isset($jenjang) ? $jenjang->nama_jenjang : old('nama_jenjang') }}" placeholder="{{ __('Nama Jenjang') }}" required />
            @error('nama_jenjang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>