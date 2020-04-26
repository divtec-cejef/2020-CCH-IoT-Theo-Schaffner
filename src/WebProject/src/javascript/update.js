/**
 * Created by Théo Schaffner @Schathe
 * version: 0.1
 * date: 21.04.2020
 */
(function (document) {
    "use strict";
    function loadTemp () {
        let xhr = new XMLHttpRequest();

        let temp = document.querySelector(".NewValueTemp")
        let hum = document.querySelector(".NewValueHum")

        xhr.send();
        if (xhr.status === 200) {
            return JSON.parse(xhr.responseText);
        }
    }

    function setValues () {
        let load = loadTemp();

        document.querySelector(".send").innerHTML = 'Données envoyés';
    }

    setValues();
}(document));


