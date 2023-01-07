@extends("base_views.base")
@section("laporan_active", "active")
@section('css')
<style>
  #map {
    height: 100%;
  }
  /* Optional: Makes the sample page fill the window. */
  #floating-panel {
    position: absolute;
    top: 10px;
    left: 25%;
    z-index: 5;
    background-color: #fff;
    padding: 5px;
    border: 1px solid #999;
    text-align: center;
    font-family: "Roboto", "sans-serif";
    line-height: 30px;
    padding-left: 10px;
  }

  #floating-panel {
    background-color: #fff;
    border: 1px solid #999;
    left: 25%;
    padding: 5px;
    position: absolute;
    top: 10px;
    z-index: 5;
  }
</style>

@endsection
@section("content")

<h1 class="h3 mb-3"><strong>Kelola Data</strong> Pelaporan</h1>
{{-- make alert dismis --}}

<div class="row">
  <div class="col-md-12">
    
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show p-3" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
      <div class="card-body">
        <form action="/laporan/create" method="POST">
          @csrf
          <div class="row">
             <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="instansi" data-bs-toggle="tooltip" data-bs-placement="right" title="Instansi yang melakukan penanganan insiden">Instansi</label>
                <select class="form-control" id="instansi" required name="instansi_id">
                  @foreach ($instansi as $i)
                    <option value="{{ $i->id }}">{{ $i->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="kecamatan">Kecamatan</label>
                <select class="form-control" id="kecamatan" required name="kecamatan_id">
                  @foreach ($kecamatan as $kec)
                    <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="kelurahan">Kelurahan</label>
                <select class="form-control" id="kelurahan" required name="kelurahan_id">
                  @foreach ($kelurahan as $kel)
                    <option value="{{ $kel->id }}">{{ $kel->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="jenis">Jenis Insiden</label>
                <select class="form-control" id="jenis" required name="jenis_id">
                  @foreach ($jenis as $j)
                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="waktu_kejadian">Waktu Kejadian</label>
                {{-- input with show error if value is null with @error --}}
                <input type="datetime-local" class="form-control @error('waktu_kejadian') is-invalid @enderror" name="waktu_kejadian" id="waktu_kejadian" max="{{ date('Y-m-d\TH:i') }}" value="{{ old('waktu_kejadian') }}" required>
                @error('waktu_kejadian')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="waktu_penanganan">Waktu Penanganan</label>
                <input type="datetime-local" class="form-control @error('waktu_penanganan') is-invalid @enderror" name="waktu_penanganan" id="waktu_penanganan" max="{{ date('Y-m-d\TH:i') }}" value="{{ old('waktu_penanganan') }}" required>
                @error('waktu_penanganan')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              {{-- make form group inline with 2 input 1 button for lat long and button to pick location --}}
              <div class="form-group">
                <label for="lokasi">Lokasi Kejadian</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('lat') is-invalid @enderror" id="lat" name="lat" placeholder="Latitude" aria-label="Latitude" aria-describedby="basic-addon2" readonly required>
                  <div class="input-group-append">
                    <span class="mx-1">,</span>
                  </div>
                  <input type="text" class="form-control @error('lng') is-invalid @enderror" id="long" name="lng" placeholder="Longitude" aria-label="Longitude" aria-describedby="basic-addon2" readonly required>
                  <div class="input-group-append">
                    {{-- make button to togle modal --}}
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Pilih Lokasi</button>
                  </div>
                </div>
                @error('lat')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">Kirim Data</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Daftar Penanganan Insiden</h5>
      </div>
      <div class="card-body">
        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Instansi / Dinas</th>
              <th>Kecamatan</th>
              <th>Kelurahan</th>
              <th>Jenis Insiden</th>
              <th>Waktu Kejadian</th>
              <th>Waktu Penanganan</th>
              <th>Lokasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($incident as $i)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $i->instansi->nama }}</td>
                <td>{{ $i->kecamatan->nama }}</td>
                <td>{{ $i->kelurahan->nama }}</td>
                <td>{{ $i->jenis->nama }}</td>
                <td>{{ $i->format_kejadian }}</td>
                <td>{{ $i->format_penanganan }}</td>
                <td>
                  <a href="https://www.google.com/maps/search/?api=1&query={{ $i->lat }},{{ $i->lng }}" target="_blank" class="btn btn-sm btn-primary">
                    <i data-feather="map-pin"></i>
                  </a>
                </td>
                <td>
                  <button class="btn btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $i->id }}">
                    <i data-feather="trash-2"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-pick-location">Pilih Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div id="map" style="width: 100%; height: 400px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="pick-location">Pilih Lokasi</button>
      </div>
    </div>
  </div>
</div>

@foreach ($incident as $i)
  {{-- make modal hapus data --}}
  <div class="modal fade" id="hapusModal{{ $i->id }}" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hapusModalLabel">Hapus Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close">
          </button>
        </div>
        <div class="modal-body">
          Apakah anda yakin akan menghapus data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <form action="/laporan/delete" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-primary" name="id" value="{{ $i->id }}">Ya</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- make modal edit data --}}
  <div class="modal fade" id="editModal{{ $i->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-bs-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <form action="#" method="POST">
            @csrf
            @method('patch')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama">Nama Instansi / Dinas</label>
                  <select name="instansi_id" id="instansi_id" class="form-control @error('instansi_id') is-invalid @enderror" required>
                    <option value="">Pilih Instansi / Dinas</option>
                    @foreach ($instansi as $i)
                      <option value="{{ $i->id }}">{{ $i->nama }}</option>
                    @endforeach
                  </select>
@endforeach


@endsection

@section('script')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUZC0h75vc7XWnralRk_NqIXmFkP5_2Uw"></script>
<script src="/location-picker/dist/location-picker.min.js"></script>

<script>
  // get kecamatan value from select
  $('#kecamatan').on('change', function() {
    var kecamatan = $(this).val();
    $('#kelurahan').prop('disabled', true);
    // call api to get kelurahan
    $.ajax({
      url: '/api/kelurahan/' + kecamatan,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        // clear select
        $('#kelurahan').empty();
        // set select to enable
        $('#kelurahan').prop('disabled', false);
        // set select option
        $.each(data, function(index, value) {
          $('#kelurahan').append('<option value="' + value.id + '">' + value.nama + '</option>');
        });
      }
    });  

  });
</script>

<script>
  const pickLocation = document.getElementById('pick-location');
  const lat = document.getElementById('lat');
  const long = document.getElementById('long');

  var lp = new locationPicker('map', {
    setCurrentPosition: true, // You can omit this, defaults to true
  }, {
    zoom: 15 // You can set any google map options here, zoom defaults to 15
  });

  pickLocation.addEventListener('click', function() {
    var location = lp.getMarkerPosition();
    lat.value = location.lat;
    long.value = location.lng;
    $('#exampleModal').modal('hide');
  });


</script>
@endsection