<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="barang-id">{{ __('Barang') }}</label>
            <select class="form-select @error('barang_id') is-invalid @enderror" name="barang_id" id="barang-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select barang') }} --</option>
                
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ isset($transak) && $transak->barang_id == $barang->id ? 'selected' : (old('barang_id') == $barang->id ? 'selected' : '') }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
            </select>
            @error('barang_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="ruangan-id">{{ __('Ruangan') }}</label>
            <select class="form-select @error('ruangan_id') is-invalid @enderror" name="ruangan_id" id="ruangan-id"
                    class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select ruangan') }} --</option>
                @foreach ($data as $ruangan)
                    <option value="{{ $ruangan->id }}" {{ old('ruangan_id', $transak->ruangan_id ?? '') == $ruangan->id ? 'selected' : '' }}>
                        {{ $ruangan->jenjang->nama_jenjang }} - {{ $ruangan->nama_ruangan }}
                    </option>
                @endforeach
            </select>
            @error('ruangan_id')
            <span class="text-danger">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="no-inventaris">{{ __('No Inventaris') }}</label>
            <input type="text" name="no_inventaris" id="no-inventaris" class="form-control @error('no_inventaris') is-invalid @enderror" value="{{ isset($transak) ? $transak->no_inventaris : old('no_inventaris') }}" placeholder="{{ __('No Inventaris') }}" required />
            @error('no_inventaris')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="jenis-pengadaan">{{ __('Jenis Pengadaan') }}</label>
            <select class="form-select @error('jenis_pengadaan') is-invalid @enderror" name="jenis_pengadaan" id="jenis-pengadaan" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select jenis pengadaan') }} --</option>
                <option value="PEMBELIAN" {{ isset($transak) && $transak->jenis_pengadaan == 'PEMBELIAN' ? 'selected' : (old('jenis_pengadaan') == 'PEMBELIAN' ? 'selected' : '') }}>
                    PEMBELIAN
                </option>
                <option value="HIBAH" {{ isset($transak) && $transak->jenis_pengadaan == 'HIBAH' ? 'selected' : (old('jenis_pengadaan') == 'HIBAH' ? 'selected' : '') }}>
                    HIBAH
                </option>
                <option value="BANTUAN" {{ isset($transak) && $transak->jenis_pengadaan == 'BANTUAN' ? 'selected' : (old('jenis_pengadaan') == 'BANTUAN' ? 'selected' : '') }}>
                    BANTUAN
                </option>
            </select>
            @error('jenis_pengadaan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="tgl-mutasi">{{ __('Tgl Mutasi') }}</label>
            <input type="date" name="tgl_mutasi" id="tgl-mutasi" class="form-control @error('tgl_mutasi') is-invalid @enderror" value="{{ isset($transak) && $transak->tgl_mutasi ? $transak->tgl_mutasi->format('Y-m-d') : old('tgl_mutasi') }}" placeholder="{{ __('Tgl Mutasi') }}" required />
            @error('tgl_mutasi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    
	<div class="col-md-6">
	<p>Jenis Mutasi</p>
        <div class="form-check mb-2">
            <input class="form-check-input @error('jenis_mutasi') is-invalid @enderror" type="radio" name="jenis_mutasi" id="barang-keluar" value="Barang Keluar" {{ isset($transak) && $transak->jenis_mutasi == 'Barang Keluar' ? 'checked' : (old('jenis_mutasi') == 'Barang Keluar' ? 'checked' : '') }} required>
            <label class="form-check-label" for="barang-keluar">
                Barang Keluar
            </label>
            @error('jenis_mutasi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input @error('jenis_mutasi') is-invalid @enderror" type="radio" name="jenis_mutasi" id="barang-masuk" value="Barang Masuk" {{ isset($transak) && $transak->jenis_mutasi == 'Barang Masuk' ? 'checked' : (old('jenis_mutasi') == 'Barang Masuk' ? 'checked' : '') }} required>
            <label class="form-check-label" for="barang-masuk">
                Barang Masuk
            </label>
            @error('jenis_mutasi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
	</div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tahun-akademik">{{ __('Tahun Akademik') }}</label>
            <input type="text" name="tahun_akademik" id="tahun-akademik" class="form-control @error('tahun_akademik') is-invalid @enderror" value="{{ isset($transak) ? $transak->tahun_akademik : old('tahun_akademik') }}" placeholder="{{ __('Tahun Akademik') }}" required />
            @error('tahun_akademik')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="periode">{{ __('Periode') }}</label>
            <input type="month" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" value="{{ isset($transak) && $transak->periode ? $transak->periode->format('Y-m') : old('periode') }}" placeholder="{{ __('Periode') }}" required />
            @error('periode')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jml-mutasi">{{ __('Total Barang') }}</label>
            <input type="number" name="jml_mutasi" id="jml-mutasi" class="form-control @error('jml_mutasi') is-invalid @enderror" value="{{ isset($transak) ? $transak->jml_mutasi : old('jml_mutasi') }}" placeholder="{{ __('Total Barang') }}" required />
            @error('jml_mutasi')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tempat-asal">{{ __('Tempat Asal') }}</label>
            <input type="text" name="tempat_asal" id="tempat-asal" class="form-control @error('tempat_asal') is-invalid @enderror" value="{{ isset($transak) ? $transak->tempat_asal : old('tempat_asal') }}" placeholder="{{ __('Tempat Asal') }}" required />
            @error('tempat_asal')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    {{-- qrcode, otomatis generate qrcode --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="qrcode">{{ __('QR Code') }}</label>
            <input type="text" name="qrcode" id="qrcode" class="form-control @error('qrcode') is-invalid @enderror" value="{{ isset($transak) ? $transak->qrcode : old('qrcode') }}" placeholder="{{ __('QR Code') }}" required />
            @error('qrcode')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>


    {{-- <div class="col-md-6">
        <div class="form-group">
            <label for="jml-baik">{{ __('Jml Baik') }}</label>
            <input type="number" name="jml_baik" id="jml-baik" class="form-control @error('jml_baik') is-invalid @enderror" value="{{ isset($transak) ? $transak->jml_baik : old('jml_baik') }}" placeholder="{{ __('Jml Baik') }}"  />
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
            <input type="number" name="jml_kurang_baik" id="jml-kurang-baik" class="form-control @error('jml_kurang_baik') is-invalid @enderror" value="{{ isset($transak) ? $transak->jml_kurang_baik : old('jml_kurang_baik') }}" placeholder="{{ __('Jml Kurang Baik') }}"  />
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
            <input type="number" name="jml_rusak_berat" id="jml-rusak-berat" class="form-control @error('jml_rusak_berat') is-invalid @enderror" value="{{ isset($transak) ? $transak->jml_rusak_berat : old('jml_rusak_berat') }}" placeholder="{{ __('Jml Rusak Berat') }}"  />
            @error('jml_rusak_berat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div> --}}
</div>