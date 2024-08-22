                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editPegawaiModal{{ $pegawai->pegawai_id }}" tabindex="-1" aria-labelledby="editPegawaiModalLabel{{ $pegawai->pegawai_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPegawaiModalLabel{{ $pegawai->pegawai_id }}">Edit Pegawai</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('pegawai.update', $pegawai->pegawai_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama_pegawai">Nama Pegawai</label>
                                                            <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nip">NIP</label>
                                                            <input type="text" class="form-control" id="nip" name="nip" value="{{ $pegawai->nip }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jabatan">Jabatan</label>
                                                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $pegawai->jabatan }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bidang_id">Bidang</label>
                                                            <select class="form-control" id="bidang_id" name="bidang_id">
                                                                <option value="">Pilih Bidang</option>
                                                                @foreach($bidangs as $bidang)
                                                                    <option value="{{ $bidang->bidang_id }}" {{ $pegawai->bidang_id == $bidang->bidang_id ? 'selected' : '' }}>{{ $bidang->name_bidang }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $pegawai->alamat }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                                <option value="Laki-laki" {{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="Perempuan" {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="no_hp">No HP</label>
                                                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $pegawai->no_hp }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ $pegawai->email }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>