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

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <form action="/laporan/create">
          {{-- buat select instansi, kecamatan, kelurahan, dan jenis --}}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="instansi">Instansi</label>
                <select class="form-control" id="instansi">
                  @foreach ($instansi as $i)
                    <option value="{{ $i->id }}">{{ $i->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="kecamatan">Kecamatan</label>
                <select class="form-control" id="kecamatan">
                  @foreach ($kecamatan as $kec)
                    <option value="{{ $kec->id }}">{{ $kec->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="kelurahan">Kelurahan</label>
                <select class="form-control" id="kelurahan">
                  @foreach ($kelurahan as $kel)
                    <option value="{{ $kel->id }}">{{ $kel->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group mb-3">
                <label for="jenis">Jenis Insiden</label>
                <select class="form-control" id="jenis">
                  @foreach ($jenis as $j)
                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            {{-- input datetime waktu_kejadian dan waktu_penanganan --}}
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="waktu_kejadian">Waktu Kejadian</label>
                <input type="datetime-local" class="form-control" id="waktu_kejadian" max="{{ date('Y-m-d\TH:i') }}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="waktu_penanganan">Waktu Penanganan</label>
                <input type="datetime-local" class="form-control" id="waktu_penanganan" max="{{ date('Y-m-d\TH:i') }}">
              </div>
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
        <h5 class="card-title">Penanganan Insiden Berdasarkan Instansi atau Dinas</h5>
      </div>
      <div class="card-body">
        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>Urutan</th>
              <th>Nama Instansi / Dinas</th>
              <th>Alamat</th>
              <th>Jumlah Penanganan Insiden</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUZC0h75vc7XWnralRk_NqIXmFkP5_2Uw&callback=initMap&libraries=visualization&v=weekly" async></script>
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
@endsection