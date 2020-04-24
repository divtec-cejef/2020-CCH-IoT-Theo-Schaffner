/**
 * Created by Théo Schaffner @Schathe
 * version: 0.1
 * date: 23.04.2020
 */
(function (document) {
    "use strict";

    let temp = [];
    let hum = [];
    let label = [];

    function loadHisorique(){
        let xhr = new XMLHttpRequest();

        let d = new Date();

        let today = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() ;

        d.setDate(d.getDate() - 7);

        let lastWeak = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() ;

        xhr.open('GET', 'https://schathe.divtec.me/IoT/api/measures/' + lastWeak + "/" + today, false);
        xhr.send(null);
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            return JSON.parse(xhr.responseText);
        }
    }

    function setValues() {
        let historique = loadHisorique();

        historique.forEach( measure => {
            temp.push(measure.temperature.last);
            hum.push(measure.humidity.last);
            label.push(measure.date);
        })
    }

    function setChart() {

        setValues();

        let ctx = document.getElementsByClassName('myChart');

        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: 'temperature',
                    fill: false,
                    data: temp,
                    pointRadius: 0,
                    borderWidth: 5,
                    borderColor: [
                        'rgba(97, 67, 182, 1)',
                    ]
                }, {
                    label: 'humidity',
                    fill: false,
                    data: hum,
                    pointRadius: 0,
                    borderWidth: 5,
                    borderColor: [
                        'rgba(47, 37, 35, 1)',
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }]
                }
            }
        })
    }

    setChart();
}(document));

