@extends('components.app')
@section('content')
    <style>
      .hover_properties {
        box-shadow: -10px -10px 0px 0px #48403d !important; 
        opacity: 1 !important;
        -webkit-transform: translate(10px, 10px) !important;
        transform: translate(10px, 10px) !important;
         z-index: 5 !important;
      }
      
    </style>
    <style type="text/css" media="print">
      footer,
      header,
      button,
      .footer-layer-bottom {
        display: none !important;
      }
      section {
        padding: 0px !important;
        margin: 0px !important;
      }
      .print-box-des{
        box-shadow: none;
        width:100% !important;
      }
      @page {
        margin-left:0;
        margin-right:0;
        margin-top:20px;
        size:auto;
      }
    </style>
    <section class="theme-container mt-4">
    
      <div>
        <div class="print-box-des">
        <div class="row">
          <div class="col-12">
            <div>
                <img src="{{asset('/assets/images/blocks-logo.png')}}" height="40px" alt="logo" />
              </div>
            <div class="personal-db-info text-center mt-4">
              <h1 style="font-size: 34px;font-weight:600;color: rgba(0, 0, 0, 0.87);">Hi {{Session::get('user_name')}}!</h1>
              <h2 style="font-size: 20px;">Your Engagement State: <span class="text-red">{{$states[$phase_code]}}</span></h2>
            </div>
            <div class="report-blocks-main border-0">
              <div class="body mx-auto position-relative" style=" width: fit-content;">
                <h5 class="progress-text meaning" style="left: -58px;top: 41%;">Meaning</h5>
                <div class="blocks">
                  <img src="{{asset('/assets/images/arrow-up.svg')}}" alt="arrow" class="arrow-up" />
                  <img src="{{asset('/assets/images/arrow-right.svg')}}" alt="arrow" class="arrow-right" />
                  <div class="d-flex flex-wrap">
                    <div class="block center flex-column {{$states[$phase_code] == 'Frustrated' ? 'hover_properties' : ''}} frustrated">
                      <h2>Frustrated</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#frustrated-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column {{$states[$phase_code] == 'Energized' ? 'hover_properties' : ''}} energized">
                      <h2>Energized</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#energized-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column pers-engaged {{$states[$phase_code] == 'Passionately Engaged' ? 'hover_properties' : ''}}">
                      <h2>Passionately Engaged</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#pass-engage-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column {{$states[$phase_code] == 'Unfulfilled' ? 'hover_properties' : ''}} unfilled">
                      <h2>Unfulfilled</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#unfilled-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column {{$states[$phase_code] == 'Neutral' ? 'hover_properties' : ''}} neutral">
                      <h2>Neutral</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#neutral-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column {{$states[$phase_code] == 'Engaged' ? 'hover_properties' : ''}} engaged">
                      <h2>Engaged</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#engage-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column stagnated {{$states[$phase_code] == 'Stagnated' ? 'hover_properties' : ''}} last">
                      <h2>Stagnated</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#stagnated-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column disconnected {{$states[$phase_code] == 'Disconnected' ? 'hover_properties' : ''}} last">
                      <h2>Disconnected</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#disconnected-modal">Learn More</a>
                    </div>
                  </div>
                </div>
                <h5 class="progress-text">Progress</h5>
              </div>
            </div>
          </div>
        </div>
        <h1 class="section-title text-center" style="font-size: 26px;">How We Identify Your Engagement State</h1>
        <div class="row">
          <div class="col-lg-6">
            <div class="chart-main border-0">
              <div class="body border-0">
                <canvas id="meaning-chart" height="60"></canvas>
                <canvas id="meaning-group-chart" class="mt-5" height="auto"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-6 border-0">
            <div class="chart-main border-0">
              <div class="body">
                <canvas id="progress-chart" height="60"></canvas>
                <canvas id="progress-group-chart" class="mt-5" height="auto"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="dougnut-chart-main mb-0 mt-3">
            <div class="head bg-transparent border-0 mb-0 p-0 text-center">
                <h2 style="font-size: 26px;">You Compared to Others in the world</h2>
            </div>
            <div class="body border-0 py-0">
                <div class="dougnut-chart-container">
                    <canvas id="dougnut-chart" height="auto"></canvas>
                </div>
            </div>
        </div>

      </div>
      <div class="center flex-wrap flex-md-nowrap mt-5">
            <a href="{{url('personal-dashboard')}}" style="text-decoration: none;"><button class="theme-btn hover me-md-2 ">Return to Dashboard</button></a>
            <a onclick="window.print()" style="text-decoration: none;"><button class="theme-btn mt-4 mt-md-0">Print pdf</button></a>
        </div>
      </div>
    </section>
    <div class="footer-layer-bottom">
      <img src="{{asset('assets/images/bottom-layer.svg')}}" alt="bottom Layer" class="w-100" />
    </div>
    <footer id="site-footer"></footer>
    <!-- Modals -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
      integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="{{asset('/assets/js/charts.js')}}"></script>
    <script>
      var labels_ = [];
      var data_= [];
      "<?php
      foreach($phase_distribution as $index=>$phase){ ?>"
      labels_["<?= $index ?>"] = "<?= $states[$phase->phase_code] ?>";
      data_["<?= $index ?>"] = "<?= $phase->percentage ?>";
      "<?php } ?>"
      const myChart5 = new Chart(ctx5, {
    type: "doughnut",
    data: {
    labels: labels_,
    datasets: [
        {
        data: data_,
        backgroundColor: [
            "#7E706C",
            "#695D5A",
            "#584E4C",
            "#48403D",
            "#ED1846",
            "#F15A22",
            "#F47920",
            "#EAE8EA",
        ],
        borderColor: [
            "#7E706C",
            "#695D5A",
            "#584E4C",
            "#48403D",
            "#ED1846",
            "#F15A22",
            "#F47920",
            "#EAE8EA",
        ],
        borderWidth: [1, 1, 1, 1, 1, 1, 1, 1],
        datalabels: {
        anchor: 'end'
      },

        }
    ]
    },
    options: {
    responsive: true,
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
        }
      }
    },
    plugins: {
        legend: {
        position: 'left'
        },
        tooltip: {
        enabled: true,
        callbacks: {
          footer: (ttItem) => {
            let sum = 0;
            let dataArr = ttItem[0].dataset.data;
            dataArr.map(data => {
              sum += Number(data);
            });

            let percentage = (ttItem[0].parsed * 100 / sum).toFixed(2) + '%';
            return `Percentage of data: ${percentage}`;
          }
        }
      },
      datalabels: {
        color: 'blue',
        labels: {
          title: {
            font: {
              weight: 'bold'
            }
          },
          value: {
            color: 'green'
          }
        }
      }


      },
    },
});

const myChart3 = new Chart(ctx3, {
    type: "bar",
    data: {
        labels: ["Feeling Of Career meaning", "Feeling Of work meaning", "Feeling Of Past work meaning"],
        datasets: [
        {
            label: "You",
            backgroundColor: "#ED1846",
            borderColor: "#ED1846",
            borderWidth: 1,
            borderRadius: 4,
            data: ["<?= $question_values[0] ?>", "<?= $question_values[1] ?>", "<?= $question_values[2] ?>"]
        },
        {
            label: "Others in the world",
            backgroundColor: "#979797",
            borderColor: "#979797",
            borderWidth: 1,
            borderRadius: 4,
            data: ["<?= $contrast_values[0] ?>", "<?= $contrast_values[1] ?>", "<?= $contrast_values[2] ?>"]
        },
        ],
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
        legend: {
            display: false,
            position: "right",
        },
        title: {
            display: false,
            text: "Feeling Of Career meaning",
        },
        },
    },
    });

    const myChart4 = new Chart(ctx4, {
    type: "bar",
    data: {
    labels: ["Feeling Of Career meaning", "Feeling Of work meaning", "Feeling Of Past work meaning"],
    datasets: [
        {
        label: "You",
        backgroundColor: "#ED1846",
        borderColor: "#ED1846",
        borderWidth: 1,
        borderRadius: 4,
        data: ["<?= $question_values[3] ?>", "<?= $question_values[4] ?>", "<?= $question_values[5] ?>"]
        },
        {
        label: "Others in the world",
        backgroundColor: "#979797",
        borderColor: "#979797",
        borderWidth: 1,
        borderRadius: 4,
        data: ["<?= $contrast_values[3] ?>", "<?= $contrast_values[4] ?>", "<?= $contrast_values[5] ?>"]
        },
    ],
    },
    options: {
    indexAxis: "y",
    responsive: true,
    plugins: {
        legend: {
        display: false,
        position: "right",
        },
        title: {
        display: false,
        text: "Feeling Of Career meaning",
        },
    },
    },
});

const ctx1 = document.getElementById("meaning-chart").getContext("2d");
const myChart1 = new Chart(ctx1, {
    type: "bar",
    data: {
        labels: ["Your Score", "Others in the world"],
        datasets: [
        {
            label: "Feeling Of Overall Meaning",
            data: ["<?= ($question_values[0] + $question_values[1] + $question_values[2]) / 3 ?>", "<?= ($contrast_values[0] + $contrast_values[1] + $contrast_values[2]) / 3 ?>"],
            backgroundColor: ["#ED1846", "#F15A22"],
            borderColor: ["#ED1846", "#F15A22"],
            borderWidth: 1,
            borderRadius: 4,
        },
        ],
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
        legend: {
            display: false,
            position: "right",
        },
        title: {
            display: true,
            text: "Feeling Of Overall Meaning",
        },
        },
    },
    });

    const ctx2 = document.getElementById("progress-chart").getContext("2d");
    const myChart2 = new Chart(ctx2, {
    type: "bar",
    data: {
        labels: ["Your Score", "Others in the world"],
        datasets: [
        {
            label: "Feeling Of Overall Meaning",
            data: ["<?= ($question_values[3] + $question_values[4] + $question_values[5]) / 3 ?>", "<?= ($contrast_values[3] + $contrast_values[4] + $contrast_values[5]) / 3 ?>"],
            backgroundColor: ["#ED1846", "#F15A22"],
            borderColor: ["#ED1846", "#F15A22"],
            borderWidth: 1,
            borderRadius: 4,
        },
        ],
    },
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
        legend: {
            display: false,
            position: "right",
        },
        title: {
            display: true,
            text: "Feeling Of Overall Meaning",
        },
        },
    },
    });
    </script>
@endsection