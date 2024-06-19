<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user-id">{{ __('User') }}</label>
            <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select user') }} --</option>
                
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ isset($pegawai) && $pegawai->user_id == $user->id ? 'selected' : (old('user_id') == $user->id ? 'selected' : '') }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
            </select>
            @error('user_id')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jabatan">{{ __('Jabatan') }}</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ isset($pegawai) ? $pegawai->jabatan : old('jabatan') }}" placeholder="{{ __('Jabatan') }}" required />
            @error('jabatan')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="no-tlpn">{{ __('No Tlpn') }}</label>
            <input type="text" name="no_tlpn" id="no-tlpn" class="form-control @error('no_tlpn') is-invalid @enderror" value="{{ (isset($pegawai) ? $pegawai->no_tlpn : old('no_tlpn')) ? old('no_tlpn') : '-' }}" placeholder="{{ __('No Tlpn') }}" />
            @error('no_tlpn')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="alamat">{{ __('Alamat') }}</label>
            <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ (isset($pegawai) ? $pegawai->alamat : old('alamat')) ? old('alamat') : '-' }}" placeholder="{{ __('Alamat') }}" />
            @error('alamat')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="jenis-jenjang">{{ __('Jenjang') }}</label>
            <input type="text" name="jenis_jenjang" id="jenis-jenis_jenjang" class="form-control @error('jenis_jenjang') is-invalid @enderror" value="{{ (isset($pegawai) ? $pegawai->jenis_jenjang : old('jenis_jenjang')) ? old('jenis_jenjang') : '-' }}" placeholder="{{ __('Jenjang') }}" />
            @error('jenis_jenjang')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama-sekolah">{{ __('Nama Sekolah') }}</label>
            <input type="text" name="nama_sekolah" id="nama-sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ (isset($pegawai) ? $pegawai->nama_sekolah : old('nama_sekolah')) ? old('nama_sekolah') : '-' }}" placeholder="{{ __('Nama Sekolah') }}" />
            @error('nama_sekolah')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>