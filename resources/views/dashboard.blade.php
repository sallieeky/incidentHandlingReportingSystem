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

<div class="row">
  <div class="col-xl-12 col-xxl-12">
    <div class="card flex-fill w-100">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Penanganan Insiden Berbasis Wilayah</h5>
        {{-- make select kecamatan --}}
        <select class="form-control w-25" id="select-kecamatan" name="wilayah">
          @foreach ($kecamatan as $item)
            <option value="{{ $item->id }}">{{ $item->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="card-body d-flex w-100">
        <div class="align-self-center chart chart-lg">
          <canvas id="chart-wilayah"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex">
  <div class="col-xl-12 col-xxl-12 d-flex">
    <div class="w-100">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Laporan Berdasarkan Jenis</h5>
            </div>
            <div class="card-body">
              <canvas id="grafik-jenis"></canvas>
            </div>
          </div>
        </div>
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
        <h5 class="card-title mb-0">Rata-rata Waktu Penanganan Insiden Berdasarkan Instansi / Dinas</h5>
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
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Penanganan Insiden Berdasarkan Instansi atau Dinas</h5>
      </div>
      <div class="card-body">
        <table id="datatables-reponsive" class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Instansi / Dinas</th>
              <th>Jumlah Penanganan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($instansi as $i)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $i->nama }}</td>
                <td>{{ $i->incident_count }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
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
    var chart_wilayah =  new Chart(document.getElementById("chart-wilayah"), {
      type: "bar",
      data: {
        labels: [
          @foreach ($kelurahan as $kel)
            "{{ $kel->nama }}",
          @endforeach
        ],
        datasets: [{
          label: "Total Penanganan Insiden",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [
            @foreach ($kelurahan as $kel)
              {{ $kel->incident_count }},
            @endforeach
          ],
          barPercentage: .5,
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
              display: true
            },
            stacked: false,
            ticks: {
              stepSize: 1
            },
            scaleLabel: {
              display: true,
              labelString: 'Jumlah Penanganan Insiden'
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            },
            scaleLabel: {
              display: true,
              labelString: 'Kelurahan'
            }
          }]
        }
      }
    });

      // get kelurahan api kalau select-kecamatan diubah
      $('#select-kecamatan').on('change', function() {
      var kecamatan_id = $(this).val();
      if (kecamatan_id) {
        $.ajax({
          url: '/api/incident_count/kelurahan/' + kecamatan_id,
          type: "GET",
          dataType: "json",
          success: function(data) {
            // store the result data map to array
            var data_kelurahan = [];
            var data_kelurahan_label = [];
            $.each(data, function(key, value) {
              data_kelurahan.push(value.incident_count);
              data_kelurahan_label.push(value.nama);
            });
            // update chart
            chart_wilayah.data.datasets[0].data = data_kelurahan;
            chart_wilayah.data.labels = data_kelurahan_label;
            chart_wilayah.update();
          }
        });
      } else {
        $('select[name="kelurahan_id"]').empty();
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
        labels: [
          @foreach ($jenis as $jns)
            "{{ $jns->nama }}",
          @endforeach
        ],
        datasets: [{
          label: "Rata-rata Waktu Penanganan (jam))",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [
            @foreach ($jenis as $jns)
              {{ $jns->mean_time }},
            @endforeach
          ],
          barPercentage: .5,
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
              display: true,
            },
            stacked: false,
            ticks: {
              stepSize: 20
            },
            scaleLabel: {
              display: true,
              labelString: 'Rata-rata Waktu Penanganan (jam)'
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            },
            scaleLabel: {
              display: true,
              labelString: 'Jenis Insiden'
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
        labels: [
          @foreach ($instansi as $ins)
            "{{ $ins->nama }}",
          @endforeach
        ],
        datasets: [{
          label: "Rata-rata Waktu Penanganan (jam)",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [
            @foreach ($instansi as $ins)
              {{ $ins->mean_time }},
            @endforeach
          ],
          barPercentage: .5,
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
              display: true
            },
            stacked: false,
            ticks: {
              stepSize: 20
            },
            scaleLabel: {
              display: true,
              labelString: 'Rata-rata Waktu Penanganan (jam)'
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            },
            scaleLabel: {
              display: true,
              labelString: 'Instansi'
            },
            // hide x-axis label
            display: false
          }]
        }
      }
    });
  });
</script>
{{-- END CHART WAKTU PETUGAS --}}

{{-- CHART POLAR JENIS --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    new Chart(document.getElementById("grafik-jenis"), {
      type: "pie",
      data: {
        labels: [
          @foreach ($jenis as $jn)
            "{{ $jn->nama }}",
          @endforeach
        ],
        datasets: [{
          data: [
            @foreach ($jenis as $jn)
              {{ $jn->incident_count }},
            @endforeach
          ],
          backgroundColor: [
            window.theme.primary,
            window.theme.success,
            window.theme.danger,
            window.theme.warning,
            window.theme.info
          ],
          borderColor: "transparent"
        }]
      },
      options: {
        maintainAspectRatio: true,
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            padding: 25,
            boxWidth: 20
          },
        },
      }
    });
  });
</script>
{{-- END CHART POLAR JENIS --}}

@endsection