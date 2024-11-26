@extends('layouts.app')

@section('content')
<div class="container mt-5">
        <h2>Daftar Peminjaman</h2>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buku</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $peminjamans)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $peminjamans->buku->judul }}</td>
                        <td>{{ $peminjamans->user->name }}</td>
                        <td>{{ $peminjamans->tgl_pinjam }}</td>
                        <td>{{ $peminjamans->tgl_kembali ?? '-' }}</td>
                        <td>{{ ucfirst($peminjamans->status) }}</td>
                        <td>
                            @if ($peminjamans->status == 'pinjam')
                                <!-- Tombol untuk membuka modal update status -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal" data-peminjaman-id="{{ $peminjamans->id }}">Kembali</button>
                            @else
                                <span class="text-muted">Selesai</span>
                            @endif
                            <form action="{{ route('peminjaman.destroy', $peminjamans->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Update Status -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Ubah Status Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin mengubah status peminjaman ini menjadi <strong>kembali</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var statusModal = document.getElementById('statusModal');
        statusModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var peminjamanId = button.getAttribute('data-peminjaman-id');

            // Update action form untuk mengubah status
            var form = document.getElementById('statusForm');
            form.action = '/peminjaman/' + peminjamanId + '/status';
        });
    </script>
@endsection