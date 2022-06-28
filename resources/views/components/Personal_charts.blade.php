<div class="border-0">
@if(count($myactions) > 0)
    <div class="col-lg-9  mx-auto">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <label class="chart-left-label f-semibold mb-0">
                    Average Score for loyalty, retention and advocacy
                </label>
            </div>
            <div class="col-lg-8">
                <canvas id="meaning-chart-employee" height="60"></canvas>
            </div>
        </div>
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
        <div class="row align-items-center">
            <div class="col-lg-4">
                <label class="chart-left-label f-semibold mb-0">
                    The organization provides a better place to work than our competititors
                </label>
            </div>
            <div class="col-lg-8">
                <canvas id="meaning-chart-employee_inner1" height="60"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-9 mx-auto mb-4">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <label class="chart-left-label f-semibold mb-0">
                    I have no reason to look elsewhere for a job
                </label>
            </div>
            <div class="col-lg-8">
                <canvas id="meaning-chart-employee_inner2" height="60"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-9 mx-auto">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <label class="chart-left-label f-semibold mb-0">
                    I would definitely recommend this organization as a place to work
                </label>
            </div>
            <div class="col-lg-8">
                <canvas id="meaning-chart-employee_inner3" height="60"></canvas>
            </div>
        </div>
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
        <div class="row align-items-center">
            <div class="col-lg-4">
                <label class="chart-left-label f-semibold mb-0">
                    Overall Average all 21
                </label>
            </div>
            <div class="col-lg-8">
                <canvas id="meaning-chart-employee_inner5" height="60"></canvas>
            </div>
        </div>
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
    <div class="chart-seperate-border mb-5"></div>
    <div class="col-lg-9 mx-auto">
        <div class="row">
            <div class="col-lg-4">
                <label class="chart-left-label f-semibold mb-0">
                    Feeling of Purpose & Inspiration<br /><br />
                    Feeling toward Organizational Patterns<br /><br />
                    Feeling of Mastery<br /><br />
                    Feeling of Autonomy
                </label>
            </div>
            <div class="col-lg-8">
                <canvas id="meaning-chart-employee_inner6" height="110px"></canvas>
            </div>
        </div>
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
                    <p>
                        Believing in company values, feeling personally aligned to them and 
                        feeling inspired by the vision are critical components of engagement. 
                        You will not attain passion without investing in these aspects of your culture.  
                        The vision represents our collective aspiration. The values speak to how we will 
                        operate as we achieve that vision. And, celebration encourages us in our pursuits. 
                        Celebrating accomplishments, along the way, is a distinguishing feature of passionate people.
                    </p>
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <label class="chart-left-label f-semibold mb-0" style="font-size:10px;">
                                I believe in the values of my team & Organization<br /><br />I believe in the vision of my team & Organization<br /><br />
                                I regularly celebrate my accomplishment at work<br /><br />I am able to be true to my personal Values at work
                            </label>
                        </div>
                        <div class="col-lg-8">
                            <canvas id="meaning-chart-employee_inner7" height="180px"></canvas>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="chart-left-label f-semibold mb-0" style="font-size:10px;">
                                I am able to learn and grow from my mistakes<br /><br />I have clear prioritized goals<br /><br />
                                I am able to make decision about the way my work gets done<br /><br />I have the real sense of ownership for my work<br /><br />
                                I see the challenges i face i opportunities not immovable road blocks
                            </label>
                        </div>
                        <div class="col-lg-8">
                            <canvas id="meaning-chart-employee_inner9" height="220px"></canvas>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-lg-5">
                            <label class="chart-left-label f-semibold mb-0" style="font-size:10px;">
                                The Organization Communicates Changes And Other Critical Infomation Effectively<br /><br />The Policies Of This Organization Are Personnel Freindly<br /><br />
                                I have The Resources I Need To Be Successful<br /><br />I Feel That Everyone In The Company Is Commited to a high  Quality Standard In their work<br /><br />
                                The organization seeks my input on things that matter<br /><br />I get lot of meaningful Feedbacks on my performance at work<br /><br />I work on a great team with people who support<br /><br />
                                the Mission and purpose of the company makes my work here important
                            </label>
                        </div>
                        <div class="col-lg-7">
                            <canvas id="meaning-chart-employee_inner8" height="400px"></canvas>
                        </div>
                    </div>
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
                    <h2>Feeling of Mastery</h2>
                </div>
                <div class="body border-0 px-4">
                    <p>This category focuses on whether you feel equipped to succeed.  Skills and knowledge are the foundation of success. Being naturally interested in one’s work also fuels curiosity and lifelong learning. This alignment supports the ongoing development of skills and knowledge. Research shows that accepting challenges to use our skills and knowledge while also asking us to get creative places us in a passionate zone. 
                    </p>
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <label class="chart-left-label f-semibold mb-0" style="font-size:10px;">
                                I Have the skills to do my job well<br /><br />I have the knowledge i need to excel in this week<br /><br />
                                I am able to be creative in the way i work<br /><br />i am naturally interested in the kind of work i am  doing
                            </label>
                        </div>
                        <div class="col-lg-7">
                            <canvas id="meaning-chart-employee_inner10" height="200px"></canvas>
                        </div>
                    </div>
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
                labels: ["", ""],
                datasets: [
                {
                    data: ["<?= $company_compareable ?>", "<?= $company_contrast ?>"],
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
                labels: ["", ""],
                datasets: [
                {
                    data: ["<?= $compare_graphs_rating[0] ?>", "<?= $compare_graphs[0] ?>"],
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
                labels: ["", ""],
                datasets: [
                {
                    data: ["<?= $compare_graphs_rating[1] ?>", "<?= $compare_graphs[1] ?>"],
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
                labels: ["", ""],
                datasets: [
                {
                    data: ["<?= $compare_graphs_rating[2] ?>", "<?= $compare_graphs[2] ?>"],
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
                labels: ["", ""],
                datasets: [
                {
                    data: ["<?= $fuel_passion_compareable; ?>", "<?= $fuel_passion_contrast ?>"],
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
                labels: [" "," "," "," "," "," "," "," "],
                datasets: [
                {
                    data: ["<?= $feeling_of_Purpose_Inspiration_compareable ?>", "<?= $feeling_of_Purpose_Inspiration_contrast ?>", "<?= $feeling_origanizational_compareable ?>", "<?= $feeling_origanizational_contrast ?>", "<?= $feeling_mastery_compareable ?>", "<?= $feeling_mastery_contrast ?>", "<?= $feeling_autonomy_compareable ?>", "<?= $feeling_autonomy_contrast ?>"],
                    backgroundColor: ["#ED1846", "#7E706C"],
                    borderColor: ["#ED1846", "#7E706C"],
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness:20,
                    barPercentage: 1.2
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
                labels: ["","","","","","","",""],
                datasets: [
                {
                    data: ["<?= $inspiration_compareable[0] ?>", "<?= $inspiration_contrast[0] ?>","<?= $inspiration_compareable[1] ?>", "<?= $inspiration_contrast[1] ?>", "<?= $inspiration_compareable[2] ?>", "<?= $inspiration_contrast[2] ?>","<?= $inspiration_compareable[3] ?>", "<?= $inspiration_contrast[3] ?>"],
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
                labels: ["","","","","","","","","","","","","","","",""],
                datasets: [
                {
                    data: ["<?= $organizational_compareable[0] ?>", "<?= $organizational_contrast[0] ?>","<?= $organizational_compareable[1] ?>", "<?= $organizational_contrast[1] ?>","<?= $organizational_compareable[2] ?>", "<?= $organizational_contrast[2] ?>","<?= $organizational_compareable[3] ?>", "<?= $organizational_contrast[3] ?>","<?= $organizational_compareable[4] ?>", "<?= $organizational_contrast[4] ?>","<?= $organizational_compareable[5] ?>", "<?= $organizational_contrast[5] ?>","<?= $organizational_compareable[6] ?>", "<?= $organizational_contrast[6] ?>","<?= $organizational_compareable[7] ?>", "<?= $organizational_contrast[7] ?>"],
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
                labels: ["","","","","","","","","",""],
                datasets: [
                {
                    data: ["<?= $autonomy_compareable[0] ?>", "<?= $autonomy_contrast[0] ?>","<?= $autonomy_compareable[1] ?>", "<?= $autonomy_contrast[1] ?>","<?= $autonomy_compareable[2] ?>", "<?= $autonomy_contrast[2] ?>", "<?= $autonomy_compareable[3] ?>", "<?= $autonomy_contrast[3] ?>","<?= $autonomy_compareable[4] ?>", "<?= $autonomy_contrast[4] ?>"],
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
                labels: ["","","","","","","",""],
                datasets: [
                {
                    data: ["<?= $mastery_compareable[0]  ?>", "<?= $mastery_contrast[0] ?>","<?= $mastery_compareable[1]  ?>", "<?= $mastery_contrast[1] ?>","<?= $mastery_compareable[2]  ?>", "<?= $mastery_contrast[2] ?>","<?= $mastery_compareable[3]  ?>", "<?= $mastery_contrast[3] ?>"],
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
                    data: ['<?= $top_strength[0] ?>', '<?= $top_strength[1] ?>', '<?= $top_strength[2]?>'],
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
                    data: ['<?= $top_improvements[0] ?>', '<?= $top_improvements[1] ?>', '<?= $top_improvements[2]?>'],
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