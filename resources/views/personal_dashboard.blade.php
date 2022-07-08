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
    <section class="theme-container">
      <div>
        <div class="progress-wrapper bg-white">
          <div class="progress-container mx-auto">
            <ul class="progress-steps ps-0 mb-0">
              <li data-counter="1" class="active"></li>
              <li data-counter="2" @if($resume) class="active" @endif></li>
              <li data-counter="3" @if($resume) class="active" @endif></li>
              <li data-counter="4"></li>
            </ul>
          </div>
        </div>
        @if(session('error_message'))
        <div id="alert_message" class="mt-3 alert alert-danger alert-dismissible col-md-12">
          <strong>{{session('error_message')}}</strong>
        </div>
        @endif
        <div class="end mt-20 mb-20">
          <a href="{{url('export-report')}}" style="text-decoration: none;"><button class="export-report">Export REPORT</button></a>
        </div>
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="personal-db-info">
              <h6>Your Personal Dashboard</h6>
              <h1>Hi {{Session::get('user_name')}}!</h1>
              <h2>Your Engagement State: <span class="text-red">{{isset($states[$phase_code]) ?  $states[$phase_code] : ''}}</span></h2>
              @if(isset($states[$phase_code] ))
              <h3>Definition of {{isset($states[$phase_code]) ?  $states[$phase_code] : ''}}</h3>
              <div class="more_data_content mb-4">
                @php
                $description = "";
                if(isset($states[$phase_code])){
                $state = str_replace(' ', '',$states[$phase_code]);

                    $description = $phase_code_description[$state];
                }
                @endphp
                {!!$description!!}
              </div>
              @else
                <h4>No Data is available</h4>
              @endif
              <!-- <p>
                Cras vel tortor nec nunc porttitor ornare pellentesque et est. Nam viverra sollicitudin molestie.
                Pellentesque sed mi convallis sapien aliquet consequat sed vel nunc. Donec viverra cursus magna. Fusce
                sollicitudin leo elit, at fermentum enim maximus vel. Cras ac finibus elit. Ut sed aliquam dolor. Duis a
                velit vitae velit consequat fringilla quis id tortor.
              </p> -->
              @if(isset($states[$phase_code] ))
              <button class="theme-btn mb-5 more_btn">Load More</button>
              @endif
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="report-blocks-main">
              <div class="head">
                <img src="{{asset('/assets/images/blocks-logo.png')}}" height="32px" alt="logo" />
              </div>
              <div class="body">
                <h5 class="progress-text meaning" style="left:50px;">Meaning</h5>
                <div class="blocks">
                  <img src="{{asset('/assets/images/arrow-up.svg')}}" alt="arrow" class="arrow-up" />
                  <img src="{{asset('/assets/images/arrow-right.svg')}}" alt="arrow" class="arrow-right" />
                  <div class="d-flex flex-wrap">
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Frustrated' ? 'hover_properties' : ''}} @endif frustrated">
                      <h2>Frustrated</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#frustrated-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Energized' ? 'hover_properties' : ''}} @endif energized">
                      <h2>Energized</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#energized-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column pers-engaged @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Passionately Engaged' ? 'hover_properties' : ''}} @endif">
                      <h2>Passionately Engaged</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#pass-engage-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Unfulfilled' ? 'hover_properties' : ''}} @endif unfilled">
                      <h2>Unfulfilled</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#unfilled-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code]))  {{$states[$phase_code] == 'Neutral' ? 'hover_properties' : ''}} @endif neutral">
                      <h2>Neutral</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#neutral-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Engaged' ? 'hover_properties' : ''}} @endif  engaged">
                      <h2>Engaged</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#engage-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column stagnated @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Stagnated' ? 'hover_properties' : ''}} @endif last">
                      <h2>Stagnated</h2>
                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#stagnated-modal">Learn More</a>
                    </div>
                    <div class="block center flex-column disconnected @if(isset($states[$phase_code])) {{$states[$phase_code] == 'Disconnected' ? 'hover_properties' : ''}} @endif last">
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
        <h1 class="section-title">More About You</h1>
        <h1 class="section-title" style="font-size: 25px;font-weight:500;">How We Identify Your Engagement State</h1>
        <div class="row">
          <div class="col-lg-6">
            <div class="chart-main">
              <div class="head">
                <h2>Meaning</h2>
              </div>
              <div class="body">
                <canvas id="meaning-chart" height="60"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                    </li>
                    <li class="list-inline-item mt-3">
                      <span class="chart-indicator orange me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
                <div class="chart-seperate-border"></div>
                <canvas id="meaning-group-chart" height="auto"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;You
                    </li>
                    <li class="list-inline-item mt-3 grey">
                    <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="chart-main">
              <div class="head">
                <h2>Meaning </h2>
              </div>
              <div class="body">
                <canvas id="progress-chart" height="60"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                    </li>
                    <li class="list-inline-item mt-3">
                      <span class="chart-indicator orange me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
                <div class="chart-seperate-border"></div>
                <canvas id="progress-group-chart" height="auto"></canvas>
                <div class="text-center">
                  <ul class="list-unstyled mb-0 indicator-container list-inline">
                    <li class="list-inline-item mt-3 me-4">
                      <span class="chart-indicator red me-2"></span>&nbsp;You
                    </li>
                    <li class="list-inline-item mt-3 grey">
                    <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="chart-desc-p">
          This shows the extent to which you see your career, your day-to-day work and the work you did a year ago as
          Meaningful. Our sense of Personal Meaning at work is determined by these three aspects. The same is true for
          Progress.
        </p>
        <p class="chart-desc-p">
          Your answers to these six questions describes your predominant emotion, as described above as your Engagement
          State. Notice if there is a difference between current work/career and past work. If the current work score is
          higher, ask yourself what has changed for the better? If the score is lower, ask yourself what has changed to
          reduce Meaning and/or Progress?
        </p>
        <p class="chart-desc-p">
          Also notice if there are differences between current work and career. If Meaning and/or Progress are higher in
          one, ask yourself what’s holding the other back?
        </p>
        <p class="chart-desc-p">
          This data is a great way to explore how you are experiencing your current work and how you are feeling about
          your career.
        </p>
      </div>
      <div class="dougnut-chart-main">
        <div class="head">
          <h2>You Compared to Others in the World</h2>
        </div>
        <div class="body">
          <div class="dougnut-chart-container">
            <canvas id="dougnut-chart" height="auto"></canvas>
          </div>
        </div>
        @if(count($myactions) > 0)
        <div class="head mt-4">
          <h2>How you feel about your company</h2>
        </div>
        @endif
        <div>
        @if(count($myactions) > 0) <p class="text-center">Employee loyalty, Retention & Advocacy for where you work</p> @endif
          @include('components.Personal_charts')
        </div>
      </div>
      <div class="center flex-wrap flex-md-nowrap">
        <a href="{{url($resume?'driver-action-plans':'myActionPlans')}}" style="text-decoration: none;"><button class="theme-btn me-md-2">{{$resume?"Resume":"Start"}} action planning</button></a>
        <a href="{{url('export-report')}}" style="text-decoration: none;"><button class="theme-btn hover w-238 mt-4 mt-md-0">Export Report</button></a>
      </div>
    </section>
    <div>
      <img src="{{asset('assets/images/bottom-layer.svg')}}" alt="bottom Layer" class="w-100" />
    </div>
    @include('components.popups')
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
      integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    
    <script src="{{asset('/assets/js/charts.js')}}"></script>
   
    <script>
      "<?php if(count($phase_distribution) == 0){ ?>"
        var labels_ = ['Data Not Available'];
        var data_= [1];
        "<?php }else{ ?>"
          var labels_ = [];
          var data_ = [];
          "<?php } ?>"
     
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
        position: 'left',
        labels: {
          fontColor: '#333',
          usePointStyle: true,
          borderRadius:10,
          padding:15
        }
        },
        datalabels: {
       formatter: (value, ctx) => {
         let datasets = ctx.chart.data.datasets;
         if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
           let sum = datasets[0].data.reduce((a, b) => a + b, 0);
           let percentage = Math.round((value / sum) * 100) + '%';
           return percentage;
         } else {
           return percentage;
         }
       },
       color: '#fff',
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
            borderRadius: 4,
            barPercentage: 0.7,
            categoryPercentage: 1,
            data: ["<?= $question_values[0] ?>", "<?= $question_values[1] ?>", "<?= $question_values[2] ?>"],
        },
        {
            label: "Others in the world",
            backgroundColor: "#979797",
            borderColor: "#979797",
            borderRadius: 4,
            categoryPercentage: 1,
            barPercentage: 0.7,
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
        borderRadius: 4,
        barPercentage: 0.7,
        categoryPercentage: 1,
        data: ["<?= $question_values[3] ?>", "<?= $question_values[4] ?>", "<?= $question_values[5] ?>"]
        },
        {
        label: "Others in the world",
        backgroundColor: "#979797",
        borderColor: "#979797",
        borderRadius: 4,
        barPercentage: 0.7,
        categoryPercentage: 1,
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
            barThickness:20,
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
            label: "Feeling Of Overall Progress",
            data: ["<?= ($question_values[3] + $question_values[4] + $question_values[5]) / 3 ?>", "<?= ($contrast_values[3] + $contrast_values[4] + $contrast_values[5]) / 3 ?>"],
            backgroundColor: ["#ED1846", "#F15A22"],
            borderColor: ["#ED1846", "#F15A22"],
            borderWidth: 1,
            borderRadius: 4,
            barThickness:20,
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