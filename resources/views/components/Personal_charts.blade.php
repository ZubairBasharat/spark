<div class="border-0">
@if(count($myactions) > 0)
    <div class="col-lg-9 mx-auto">
        <canvas id="meaning-chart-employee" height="60"></canvas>
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
    </div>
    <div class="chart-seperate-border mb-4"></div>
    <div class="col-lg-9 mx-auto mb-4">
        <canvas id="meaning-chart-employee_inner1" height="60"></canvas>
    </div>
    <div class="col-lg-9 mx-auto mb-4">
        <canvas id="meaning-chart-employee_inner2" height="60"></canvas>
    </div>
    <div class="col-lg-9 mx-auto">
        <canvas id="meaning-chart-employee_inner3" height="60"></canvas>
        <div class="text-center">
            <ul class="list-unstyled mb-0 indicator-container list-inline">
                <li class="list-inline-item mt-3 me-4">
                    <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                </li>
                <li class="list-inline-item mt-3">
                    <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                </li>
            </ul>
        </div>
    </div>
    @endif
    @if(count($myactions_two) > 0)
    <div class="head mt-5">
        <h2 class="d-flex align-items-center"><span style="width: 108px;overflow: hidden;display: inline-block;"><img src="{{asset('assets/images/slide-logo.png')}}" alt="logo" /></span>&nbsp;21 Engagement Drivers</h2>
    </div>
    <div>
        <h5 class="mb-3">What Drives You?</h5>
        <p>Below shows your average score for 21 survey statements that represent the core Drivers of passion. These 21 Drivers naturally group into four categories that we call Purpose & Inspiration, Organizational Patterns, Mastery and Autonomy. The graph below shows your average scores for each category. Compare each of the four categories to one another to understand your strengths and improvement areas. Note any significant discrepancies between the categories to focus your action plan on the critical opportunities. It is just as important to build on strengths as it is to address improvement areas. Spend equal time understanding both. 
        <br />  <br />Where are your  strengths or opportunities? Which of these engagement drivers, if part of an action plan, would support your passion at work?</p>
    </div>
    <div class="row">
        <div class="col-lg-6 mt-4">
            <h5 class="mb-4 text-center">Your Top Strengths</h5>
            <div class="px-3">
                <canvas id="line_chart_data1" height="200"></canvas>
            </div>
        </div>
        <div class="col-lg-6 mt-4">
            <h5 class="mb-4 text-center">Your Top Improvement Areas</h5>
            <div class="px-3">
                <canvas id="line_chart_data2" height="200"></canvas>
            </div>
        </div>
    </div>
    @endif
    @if(count($myactions) > 0)
    <div class="head mt-5">
        <h2>What Fuels Your Passion</h2>
    </div>
    <p>
        Your Overall Average of the 21 Engagement Drivers are an indication of how well supported Meaning 
        and Progress is for you. Focusing on specific engagement drivers will help strengthen your engagement. 
    </p>
    <div class="col-lg-9 mx-auto mb-5">
        <canvas id="meaning-chart-employee_inner5" height="60"></canvas>
    </div>
    <div class="chart-seperate-border mb-5"></div>
    <div class="col-lg-9 mx-auto">
        <canvas id="meaning-chart-employee_inner6" height="60"></canvas>
        <div class="text-center">
            <ul class="list-unstyled mb-0 pb-3 indicator-container list-inline">
                <li class="list-inline-item mt-3 me-4">
                    <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                </li>
                <li class="list-inline-item mt-3">
                    <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mt-4">
            <div class="chart-main">
                <div class="head mb-0">
                    <h2>Feeling of Purpose & Inspiration</h2>
                </div>
                <div class="body border-0 px-4">
                    <p>Believing in company values, feeling personally aligned to them and 
                        feeling inspired by the vision are critical components of engagement. 
                        You will not attain passion without investing in these aspects of your culture.  
                        The vision represents our collective aspiration. The values speak to how we will 
                        operate as we achieve that vision. And, celebration encourages us in our pursuits. 
                        Celebrating accomplishments, along the way, is a distinguishing feature of passionate people.
                    </p>
                    <canvas id="meaning-chart-employee_inner7" height="auto"></canvas>
                    <div class="text-center">
                        <ul class="list-unstyled mb-0 pb-3 indicator-container list-inline">
                            <li class="list-inline-item mt-3 me-4">
                                <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                            </li>
                            <li class="list-inline-item mt-3">
                                <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="chart-main mt-4">
                <div class="head mb-0">
                    <h2>Feeling of Autonomy</h2>
                </div>
                <div class="body border-0 px-4">
                    <p>This measures how empowered you feel to do what you know needs to be done without having to check-in all the time or wait for decisions to be made. Our research shows that autonomy and ownership come from knowing clearly what you need to accomplish, making decisions about how you achieve these goals, learning from the mistakes along the way, and understanding that there is always a way forward, even with great challenges. 
                    </p>
                    <canvas id="meaning-chart-employee_inner9" height="auto"></canvas>
                    <div class="text-center">
                        <ul class="list-unstyled mb-0 pb-3 indicator-container list-inline">
                            <li class="list-inline-item mt-3 me-4">
                                <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                            </li>
                            <li class="list-inline-item mt-3">
                                <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-4">
            <div class="chart-main">
                <div class="head mb-0">
                    <h2>Feeling toward Organizational Patterns</h2>
                </div>
                <div class="body border-0 px-4">
                    <p>This category has eight elements ranging from communications to support as well as the importance of contribution. Notice how the three communication statements relate (i.e., general communications, input and feedback). Then consider the support systems from policies to resources to the team. And, finally, notice how connected people feel to the purpose of the organization and the contributions of their peers. 
                    </p>
                    <canvas id="meaning-chart-employee_inner8" height="auto"></canvas>
                    <div class="text-center">
                        <ul class="list-unstyled mb-0 pb-3 indicator-container list-inline">
                            <li class="list-inline-item mt-3 me-4">
                                <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                            </li>
                            <li class="list-inline-item mt-3">
                                <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="chart-main mt-4">
                <div class="head mb-0">
                    <h2>Feeling of Autonomy</h2>
                </div>
                <div class="body border-0 px-4">
                    <p>This measures how empowered you feel to do what you know needs to be done without having to check-in all the time or wait for decisions to be made. Our research shows that autonomy and ownership come from knowing clearly what you need to accomplish, making decisions about how you achieve these goals, learning from the mistakes along the way, and understanding that there is always a way forward, even with great challenges. 
                    </p>
                    <canvas id="meaning-chart-employee_inner10" height="auto"></canvas>
                    <div class="text-center">
                        <ul class="list-unstyled mb-0 pb-3 indicator-container list-inline">
                            <li class="list-inline-item mt-3 me-4">
                                <span class="chart-indicator red me-2"></span>&nbsp;Your Score
                            </li>
                            <li class="list-inline-item mt-3">
                                <span class="chart-indicator grey me-2"></span>&nbsp;Others in the world
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@section('scripts')
<script>
    $(document).ready(function(){
        "@if(count($myactions) > 0)"
        const ctx_employee = document.getElementById("meaning-chart-employee").getContext("2d");
        const Chart_employee = new Chart(ctx_employee, {
            type: "bar",
            data: {
                labels: ["Average Score for loyalty,", "retention and advocacy"],
                datasets: [
                {
                    data: [1, 9],
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
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });

        // inner 1

        const ctx_employee_inner1 = document.getElementById("meaning-chart-employee_inner1").getContext("2d");
        const Chart_employee_inner1 = new Chart(ctx_employee_inner1, {
            type: "bar",
            data: {
                labels: ["The organization provides a better place to work than our competititors", ""],
                datasets: [
                {
                    data: [1, 9],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
 // inner 2
        const ctx_employee_inner2 = document.getElementById("meaning-chart-employee_inner2").getContext("2d");
        const Chart_employee_inner2 = new Chart(ctx_employee_inner2, {
            type: "bar",
            data: {
                labels: ["i have no reason to look elsewhere for a job", ""],
                datasets: [
                {
                    data: [1, 9],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
 // inner 3
        const ctx_employee_inner3 = document.getElementById("meaning-chart-employee_inner3").getContext("2d");
        const Chart_employee_inner3 = new Chart(ctx_employee_inner3, {
            type: "bar",
            data: {
                labels: ["i would definitely recommend this organization as a place to work", ""],
                datasets: [
                {
                    data: [1, 9],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                        position: "bottom",
                    },
                    title: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'start',
                        align: '-45',
                        clamp: true,
                        color: "orange",
                    }
    
                },
                scale: {
        pointLabels :{
           fontStyle: "bold",
        }
    }
            },
        });
         // inner 5
        const ctx_employee_inner5 = document.getElementById("meaning-chart-employee_inner5").getContext("2d");
        const Chart_employee_inner5 = new Chart(ctx_employee_inner5, {
            type: "bar",
            data: {
                labels: ["Overall Average all 21", ""],
                datasets: [
                {
                    data: [1, 9],
                    backgroundColor: ["#ED1846", "#F15A22"],
                    borderColor: ["#ED1846", "#F15A22"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
         // inner 6
        const ctx_employee_inner6 = document.getElementById("meaning-chart-employee_inner6").getContext("2d");
        const Chart_employee_inner6 = new Chart(ctx_employee_inner6, {
            type: "bar",
            data: {
                labels: [" Feeling of Purpose & Inspiration","Feeling toward Organizational Patterns",
            "Feeling of Mastery","Feeling of Autonomy"],
                datasets: [
                {
                    data: [1, 8,1, 4],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
        // inner 7
        const ctx_employee_inner7 = document.getElementById("meaning-chart-employee_inner7").getContext("2d");
        const Chart_employee_inner7 = new Chart(ctx_employee_inner7, {
            type: "bar",
            data: {
                labels: ["I believe in the values of my team & Organization","I believe in the vision of my team & Organization",
            "I regularly celebrate my accomplishment at work","I am able to be true to my personal Values at work"],
                datasets: [
                {
                    data: [1, 8,1, 4],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
        // inner 8
        const ctx_employee_inner8 = document.getElementById("meaning-chart-employee_inner8").getContext("2d");
        const Chart_employee_inner8 = new Chart(ctx_employee_inner8, {
            type: "bar",
            data: {
                labels: ["The Organization Communicates Changes And Other Critical Infomation Effectively","The Policies Of This Organization Are Personnel Freindly",
            "I have The Resources I Need To Be Successful","I Feel That Everyone In The Company Is Commited to a high  Quality Standard In their work",
        "The organization seeks my input on things that matter","I get lot of meaningful Feedbacks on my performance at work","I work on a great team with people who support ",
    "the Mission and purpose of the company makes my work here important"],
                datasets: [
                {
                    data: [1, 8,1, 4,1, 8,1, 4],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
        // inner 9
        const ctx_employee_inner9 = document.getElementById("meaning-chart-employee_inner9").getContext("2d");
        const Chart_employee_inner9 = new Chart(ctx_employee_inner9, {
            type: "bar",
            data: {
                labels: ["I am able to learn and grow from my mistakes","I have clear prioritized goals",
            "I am able to make decision about the way my work gets done","I have the real sense of ownership for my work",
            "I see the challenges i face i opportunities not immovable road blocks"],
                datasets: [
                {
                    data: [1, 8,1, 4,1, 4],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                plugins: {
                legend: {
                    display: false,
                    position: "bottom",
                },
                title: {
                    display: false,
                },
                },
            },
        });
         // inner 10
         const ctx_employee_inner10 = document.getElementById("meaning-chart-employee_inner10").getContext("2d");
        const Chart_employee_inner10 = new Chart(ctx_employee_inner10, {
            type: "bar",
            data: {
                labels: ["I Have the skills to do my job well","I have the knowledge i need to excel in this week",
            "I am able to be creative in the way i work","i am naturally interested in the kind of work i am  doing"],
                datasets: [
                {
                    data: [1, 8,1, 4],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20,
                },
                ],
            },
            options: {
                indexAxis: "y",
                responsive: true,
                 scales: {
                    y: {
                        ticks: {
                            // textStrokeWidth:96,
                            crossAlign: 'start'
                        },
                        // afterSetDimensions: (scale) => {
                        //     scale.maxWidth = 96;
                        // }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        position: "bottom",
                    },
                    title: {
                        display: false,
                    },
                },
            },
        });
        "@endif"

        "@if(count($myactions_two) > 0)"
        // line chart data1
        const line_chart_data_canvas1 = document.getElementById("line_chart_data1").getContext("2d");
        const line_chart_data1 = new Chart(line_chart_data_canvas1, {
            type: "bar",
            data: {
                labels: ["I believe in the values of my organization","I regularly celebrate my accomplishment at work",
            "I have The Resources I Need To Be Successful"],
                datasets: [
                {
                    data: [25, 50,100],
                    backgroundColor: ["#ED1846", "#FFC20E","#03BD5B"],
                    borderColor: ["#ED1846", "#FFC20E","#03BD5B"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:31
                },
                ],
            },
            options: {
              
                scales:{
                    x: {
                        display: false
                    }
                },
                responsive: true,
                plugins: {
                legend: {
                    display: true,
                    position: "bottom",
              
                        labels: {
                            generateLabels: (chart) => {
                                const datasets = chart.data.datasets;
                                return datasets[0].data.map((data, i) => ({
                                text: `${chart.data.labels[i]} ${data}`,
                                fillStyle: datasets[0].backgroundColor[i],
                                }))
                            },
                            fontColor: '#333',
                            usePointStyle: true,
                            borderRadius:10,
                            padding:15
                        }
                    
                },
                title: {
                    display: false,
                },
                },
            },
        });
          // line chart data2
          const line_chart_data_canvas2 = document.getElementById("line_chart_data2").getContext("2d");
        const line_chart_data2 = new Chart(line_chart_data_canvas2, {
            type: "bar",
            data: {
                labels: ["I Have the skills to do my job well","I am able to be creative in the way i work",
            "I have clear prioritized goals"],
                datasets: [
                {
                    data: [25, 50,100],
                    backgroundColor: ["#7E706C", "#0F0F10","#8D2F07"],
                    borderColor: ["#7E706C", "#0F0F10","#8D2F07"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:31
                },
                ],
            },
            options: {
              
                scales:{
                    x: {
                        display: false
                    }
                },
                responsive: true,
                plugins: {
                    
                legend: {
                    display: true,
                    position: "bottom",
              
                        labels: {
                            generateLabels: (chart) => {
                                const datasets = chart.data.datasets;
                                return datasets[0].data.map((data, i) => ({
                                text: `${chart.data.labels[i]} ${data}`,
                                fillStyle: datasets[0].backgroundColor[i],
                                }))
                            },

                            fontColor: '#333',
                            usePointStyle: true,
                            borderRadius:10,
                            padding:15
                        }
                    
                },
                title: {
                    display: false,
                },
                },
            },
        });
        "@endif"
    })
</script>
@endsection