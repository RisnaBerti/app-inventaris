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
</div>