@extends('layouts.backend.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container mt-5">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengaduan</h1>
            <a href="{{ route('pengaduan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Tambah Pengaduan</a>
        </div>

        <!-- Content Row -->

        <div class="row my-5">
            <table class="table border-left-primary shadow rounded">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Isi Laporan</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                </thead>
                <tbody>
                    @if(count($pengaduans) > 0)
                        @foreach($pengaduans as $key => $pengaduan)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $pengaduan->tgl_pengaduan }}</td>
                                <td>{{ $pengaduan->user->name }}</td>
                                <td>{{ Str::limit($pengaduan->isi_laporan, 30) }}</td>
                                <td>
                                    <a href="{{ asset('foto') }}/{{ $pengaduan->foto }}" target="_blank">
                                        <img src="{{ asset('foto') }}/{{ $pengaduan->foto }}" width="100">
                                    </a>
                                </td>
                                <td>
                                    @if($pengaduan->status == '0')
                                        <span class="px-3 bg-gradient-danger text-white">
                                            {{ $pengaduan->status }}
                                        </span>
                                        @elseif ($pengaduan->status == 'Proses')
                                            <span class="px-3 bg-gradient-warning text-white">{{ $pengaduan->status }}</span>
                                        @else
                                            <span class="px-3 bg-gradient-success text-white">{{ $pengaduan->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()->role == 0)
                                        <a href="{{ route('pengaduan.show', [$pengaduan->id]) }}">
                                            <button class="btn btn-outline-success">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('pengaduan.edit', [$pengaduan->id]) }}">
                                            <button class="btn btn-outline-success">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </button>
                                        </a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $pengaduan->id }}">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $pengaduan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('pengaduan.destroy', [$pengaduan->id]) }}" method="post">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">DELETE</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <a href="{{ route('pengaduan.show', [$pengaduan->id]) }}">
                                            <button class="btn btn-outline-success">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <td>Tidak ada pengaduan yang dapat ditampilkan.</td>
                    @endif
                    </tbody>               
              </table>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend-template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend-template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend-template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend-template/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('backend-template/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend-template/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('backend-template/js/demo/chart-pie-demo.js') }}"></script>
@endsection