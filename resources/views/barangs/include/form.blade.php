<div class="row mb-2">
    {{-- <div class="col-md-6">
        <div class="form-group">
            <label for="kategori">{{ __('Kategori') }}</label>
            <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="kategori" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select kategori') }} --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ isset($barang) && $barang->kategori_id == $kategori->id ? 'selected' : (old('kategori') == $kategori->id ? 'selected' : '') }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div> --}}
    {{-- jenis barang --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="kategori-barang">{{ __('Kategori Barang') }}</label>
            <input type="text" name="kategori_barang" id="kategori-barang"
                class="form-control @error('kategori_barang') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->kategori_barang : old('kategori_barang') }}"
                placeholder="{{ __('Kategori Barang') }}" required />
            @error('kategori_barang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-barang">{{ __('Nama Barang') }}</label>
            <input type="text" name="nama_barang" id="nama-barang"
                class="form-control @error('nama_barang') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->nama_barang : old('nama_barang') }}"
                placeholder="{{ __('Nama Barang') }}" required />
            @error('nama_barang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="kode-barang">{{ __('Kode Barang') }}</label>
            <input type="text" name="kode_barang" id="kode-barang"
                class="form-control @error('kode_barang') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->kode_barang : old('kode_barang') }}"
                placeholder="{{ __('Kode Barang') }}" required />
            @error('kode_barang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
            {{-- @isset($barang) --}}
                <div id="kode-barang" class="form-text ">
                    {{ __('Kode barang wajib unik.') }}
                </div>
            {{-- @endisset --}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="merk-model">{{ __('Merk Model') }}</label>
            <input type="text" name="merk_model" id="merk-model"
                class="form-control @error('merk_model') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->merk_model : old('merk_model') }}"
                placeholder="{{ __('Merk Model') }}" required />
            @error('merk_model')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="ukuran">{{ __('Ukuran') }}</label>
            <input type="text" name="ukuran" id="ukuran"
                class="form-control @error('ukuran') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->ukuran : old('ukuran') }}" placeholder="{{ __('Ukuran') }}"
                required />
            @error('ukuran')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="bahan">{{ __('Bahan') }}</label>
            <input type="text" name="bahan" id="bahan"
                class="form-control @error('bahan') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->bahan : old('bahan') }}" placeholder="{{ __('Bahan') }}"
                required />
            @error('bahan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="tahun-pembuatan-pembelian">{{ __('Tahun Pembuatan Pembelian') }}</label>
            <select class="form-select @error('tahun_pembuatan_pembelian') is-invalid @enderror"
                name="tahun_pembuatan_pembelian" id="tahun-pembuatan-pembelian" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select tahun pembuatan pembelian') }} --</option>

                @foreach (range(1900, strftime('%Y', time())) as $year)
                    <option value="{{ $year }}"
                        {{ isset($barang) && $barang->tahun_pembuatan_pembelian == $year ? 'selected' : (old('tahun_pembuatan_pembelian') == $year ? 'selected' : '') }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
            @error('tahun_pembuatan_pembelian')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="satuan">{{ __('Satuan') }}</label>
            <input type="text" name="satuan" id="satuan"
                class="form-control @error('satuan') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->satuan : old('satuan') }}" placeholder="{{ __('Satuan') }}"
                required />
            @error('satuan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jml-barang">{{ __('Jml Barang') }}</label>
            <input type="number" name="jml_barang" id="jml-barang"
                class="form-control @error('jml_barang') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->jml_barang : old('jml_barang') }}"
                placeholder="{{ __('Jml Barang') }}" value="0" required readonly />
            @error('jml_barang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="foto-barang">{{ __('Foto Barang') }}</label>
            <input type="file" name="foto_barang" id="foto-barang"
                class="form-control @error('foto_barang') is-invalid @enderror"
                value="{{ isset($barang) ? $barang->foto_barang : old('foto_barang') }}"
                placeholder="{{ __('Foto Barang') }}" />
            @error('foto_barang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
