/**
 * Created by Théo Schaffner @Schathe
 * version: 0.1
 * date: 21.04.2020
 */
(function (document) {
    "use strict";
    function loadTemp () {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'https://schathe.divtec.me/IoT/api/measures', false);
        xhr.send(null);
        if (xhr.status === 200) {
            return JSON.parse(xhr.responseText);
        }
    }

    function setValues () {
        let load = loadTemp();

        document.querySelector(".TempNow").innerHTML = '<div>' + load.last.temperature + '°C<\div>';
        document.querySelector(".HumNow").innerHTML = '<div>' + load.last.humidity + '%<\div>';
        document.querySelector(".TempMax").innerHTML = '<div>' + load.temperature.max + '°C<\div>';
        document.querySelector(".TempMin").innerHTML = '<div>' + load.temperature.min + '°C<\div>';
        document.querySelector(".HumMax").innerHTML = '<div>' + load.humidity.max + '%<\div>';
        document.querySelector(".HumMin").innerHTML = '<div>' + load.humidity.min + '%<\div>';
    }

    setValues();
}(document));
