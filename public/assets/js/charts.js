const ctx1 = document.getElementById("meaning-chart").getContext("2d");
const myChart1 = new Chart(ctx1, {
    type: "bar",
    data: {
        labels: ["Your Score", "Others in the world"],
        datasets: [
        {
            label: "Feeling Of Overall Meaning",
            data: [5.0, 4.3],
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
            data: [5.0, 4.3],
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

    const ctx3 = document.getElementById("meaning-group-chart").getContext("2d");
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
            data: [5, 5, 5]
        },
        {
            label: "Others in the world",
            backgroundColor: "#979797",
            borderColor: "#979797",
            borderWidth: 1,
            borderRadius: 4,
            data: [4.3, 4.3, 4.3]
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

const ctx4 = document.getElementById("progress-group-chart").getContext("2d");
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
        data: [5, 5, 5]
        },
        {
        label: "Others in the world",
        backgroundColor: "#979797",
        borderColor: "#979797",
        borderWidth: 1,
        borderRadius: 4,
        data: [4.3, 4.3, 4.3]
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

const ctx5 = document.getElementById("dougnut-chart").getContext("2d");
const myChart5 = new Chart(ctx5, {
    type: "doughnut",
    data: {
    labels: [
        "Disconnected",
        "Stagnated",
        "Unfulfilled",
        "Frustrated",
        "Passionately Engaged",
        "Engaged",
        "Energized",
        "Neutral",
    ],
    datasets: [
        {
        data: [32.6, 5.0, 8.4, 6.8, 19.4, 6.3, 20, 1.5],
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
        borderWidth: [1, 1, 1, 1, 1, 1, 1, 1]
        }
    ]
    },
    options: {
    responsive: true,
    plugins: {
        legend: {
        position: 'left'
        }
    }
    },
});