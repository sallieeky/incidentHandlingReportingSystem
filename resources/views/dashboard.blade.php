@extends("base_views.base")
@section("dashoard_active", "active")
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

<script>
      let map, heatmap;

    function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 13,
      center: { lat: -0.8762408664865664, lng: 131.25496471007807 },
      mapTypeId: "satellite",
    });
    heatmap = new google.maps.visualization.HeatmapLayer({
      data: getPoints(),
      map: map,
    });
    document
      .getElementById("toggle-heatmap")
      .addEventListener("click", toggleHeatmap);
    document
      .getElementById("change-gradient")
      .addEventListener("click", changeGradient);
    document
      .getElementById("change-opacity")
      .addEventListener("click", changeOpacity);
    document
      .getElementById("change-radius")
      .addEventListener("click", changeRadius);
    }

    function toggleHeatmap() {
    heatmap.setMap(heatmap.getMap() ? null : map);
    }

    function changeGradient() {
    const gradient = [
      "rgba(0, 255, 255, 0)",
      "rgba(0, 255, 255, 1)",
      "rgba(0, 191, 255, 1)",
      "rgba(0, 127, 255, 1)",
      "rgba(0, 63, 255, 1)",
      "rgba(0, 0, 255, 1)",
      "rgba(0, 0, 223, 1)",
      "rgba(0, 0, 191, 1)",
      "rgba(0, 0, 159, 1)",
      "rgba(0, 0, 127, 1)",
      "rgba(63, 0, 91, 1)",
      "rgba(127, 0, 63, 1)",
      "rgba(191, 0, 31, 1)",
      "rgba(255, 0, 0, 1)",
    ];

    heatmap.set("gradient", heatmap.get("gradient") ? null : gradient);
    }

    function changeRadius() {
    heatmap.set("radius", heatmap.get("radius") ? null : 20);
    }

    function changeOpacity() {
    heatmap.set("opacity", heatmap.get("opacity") ? null : 0.2);
    }

    // Heatmap data: 500 Points
    function getPoints() {
      return [
        @foreach ($incident as $item)
          new google.maps.LatLng({{ $item->lat }}, {{ $item->lng }}),          
        @endforeach
      ];
    }
</script>

@endsection
@section("content")

<h1 class="h3 mb-3"><strong>Statistik</strong> Penanganan Insiden</h1>

<div class="row d-flex">
  <div class="col-xl-6 col-xxl-5 d-flex">
    <div class="w-100">
      {{-- 4 CARD SECTION --}}
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Laporan</h5>
                </div>
                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="file-text"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">2.382</h1>
              <div class="mb-0">
                <span class="text-muted">Since last week</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Pengaduan</h5>
                </div>
                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="file-text"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">21.300</h1>
              <div class="mb-0">
                <span class="text-muted">Since last week</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Informasi</h5>
                </div>
                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="file-text"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">14.212</h1>
              <div class="mb-0">
                <span class="text-muted">Since last week</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- END 4 CARD SECTION --}}
    </div>
  </div>
  
  {{-- INSIDEN BASIS WILAYAH --}}
  <div class="col-xl-6 col-xxl-7">
    <div class="card flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Penanganan Insiden Berbasis Wilayah</h5>
      </div>
      <div class="card-body d-flex w-100">
        <div class="align-self-center chart chart-lg">
          <canvas id="chart-wilayah"></canvas>
        </div>
      </div>
    </div>
  </div>
  {{-- INSIDEN BASIS WILAYAH --}}
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
            @foreach ($instansi as $is)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $is->nama }}</td>
              <td>{{ $is->alamat }}</td>
              <td>{{ $is->jumlah_penanganan }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-6 col-xxl-6">
    <div class="card flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Rata-rata Waktu Penanganan Insiden Berdasarkan Jenis</h5>
      </div>
      <div class="card-body d-flex w-100">
        <div class="align-self-center chart chart-lg">
          <canvas id="chart-waktu-jenis"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-6 col-xxl-6">
    <div class="card flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Rata-rata Waktu Penanganan Insiden Berdasarkan Petugas Dispatcher</h5>
      </div>
      <div class="card-body d-flex w-100">
        <div class="align-self-center chart chart-lg">
          <canvas id="chart-waktu-petugas"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Heatmap Lokasi Pelaporan Insiden</h5>
      </div>
      <div class="card-body">
        <div class="content" id="map" style="height: 500px;"></div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUZC0h75vc7XWnralRk_NqIXmFkP5_2Uw&callback=initMap&libraries=visualization&v=weekly" async></script>

{{-- CHART WILAYAH --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("chart-wilayah"), {
      type: "bar",
      data: {
        labels: [@foreach ($wilayah as $wl) "{{ $wl->nama }}", @endforeach],
        datasets: [{
          label: "Tahun Ini",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [20, 13, 19, 9, 23, 20, 13, 19, 9, 23],
          barPercentage: .75,
          categoryPercentage: .5
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false
            },
            stacked: false,
            ticks: {
              stepSize: 20
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            }
          }]
        }
      }
    });
  });
</script>
{{-- END CHART WILAYAH --}}

{{-- CHART WAKTU JENIS --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("chart-waktu-jenis"), {
      type: "bar",
      data: {
        labels: ["Jenis 1", "Jenis 2", "Jenis 3", "Jenis 4", "Jenis 5"],
        datasets: [{
          label: "Tahun Ini",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [20, 13, 19, 9, 23],
          barPercentage: .75,
          categoryPercentage: .5
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false
            },
            stacked: false,
            ticks: {
              stepSize: 20
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            }
          }]
        }
      }
    });
  });
</script>
{{-- END CHART WAKTU JENIS --}}

{{-- CHART WAKTU PETUGAS --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("chart-waktu-petugas"), {
      type: "bar",
      data: {
        labels: ["Petugas 1", "Petugas 2", "Petugas 3", "Petugas 4", "Petugas 5"],
        datasets: [{
          label: "Tahun Ini",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [20, 13, 19, 9, 23],
          barPercentage: .75,
          categoryPercentage: .5
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false
            },
            stacked: false,
            ticks: {
              stepSize: 20
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            }
          }]
        }
      }
    });
  });
</script>
{{-- END CHART WAKTU PETUGAS --}}

@endsection