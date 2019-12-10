// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

controllers.controller("MapCtrl",
function ($scope, $mdDialog, PostazioneService) {
    $scope.map = null;
    $scope.mapDate = new Date();
    $scope.offset = 0;
    $scope.freeFrom = null;
    $scope.freeTo = null;
    $scope.displaySituation = true;
    $scope.displayAvailability = false;
    $scope.options = {};


    function Dimension() {
        this.name = null;
        this.count = 0;
        this.element = [];
    }

    function namedDimension(name) {
        var d = new Dimension();
        d.name = name;
        return d;
    }

    function Map6() {
        this.x = [];

        this.add = function (postazione) {

            try {
                // Cerco la colonna
                var xp = this.x[postazione.x - 1];

                // Creo la colonna se non la trovo
                if (xp === undefined) {
                    // Colmo l'eventuale gap
                    for (var i = this.x.length; i < postazione.x - 1; i++) {
                        this.x.push(new Dimension());
                    }

                    // Creo la colonna
                    xp = namedDimension(postazione.fila);
                    xp.count++;
                    this.x.push(xp);
                }

                // Cerco la fila
                var yp = xp.element[postazione.y - 1];

                // Creo la fila se non la trovo
                if (yp === undefined) {
                    // Colmo l'eventuale gap
                    for (var i = xp.element.length; i < postazione.y - 1; i++) {
                        xp.element.push(new Dimension());
                    }

                    // Creo la colonna
                    yp = namedDimension(postazione.colonna);
                    yp.count++;
                    xp.element.push(yp);
                }

                yp.element = postazione;
                yp.name = postazione.colonna;
            } catch (Exception) {
                console.log(postazione);
                debugger;
            }
        };
    }

    /*
     * Per ogni settore creo una matrice colonne x file considerando
     * l'ordinamento delle coordinate ed eventuali buchi. Cioè colonna 1
     * seguita da colonna 4 deve lascare due posti vuoti (4 - 1 = 2).
     * L'aritmetica è più fantasiosa con le colonne (F - C = 2).
     * I posti vuoti devono occupare fisicamente spazio per mantenere
     * la struttura. Considerare anche il tipo di postazione in fase di
     * rendering.
     * @param {type} postazioni
     * @returns {undefined}
     */
    function drawMap(postazioni) {
        var map = new Map6();
        for (var i = 0; i < postazioni.length; i++)
            map.add(PostazioneService.decorate(postazioni[i]));
        $scope.map = map;
    }

    /**
     * Interroga l'API sulla situazione spiaggia alla data impostata.
     */
    $scope.updateMap = function () {
        console.log("Updating map");
        var t = new Date();
        $scope.freeFrom = null;
        $scope.freeTo = null;
        $scope.displaySituation = true;
        $scope.displayAvailability = false;

        var parametri = {
            data: $scope.mapDate
        };

        PostazioneService.api.spot.query(parametri,
        function (response) {
            drawMap(response);
            console.log("Map updated in " + (new Date() - t) + " ms");
        }, function (error) {
            console.log("error: " + error);
            alert("Impossibile scaricare la lista delle postazioni");
        });
    };

    $scope.updateFreeSpots = function () {
        if ($scope.freeFrom === null)
            return;

        if ($scope.freeTo === null)
            return;

        if ($scope.freeFrom > $scope.freeTo) {
            alert("Inverti le date del periodo");
            return;
        }

        console.log("Updating free spot map");
        var t = new Date();
        $scope.mapDate = null;
        $scope.displaySituation = false;
        $scope.displayAvailability = true;

        /*
         var parametri = {
         disp_inizio: $scope.freeFrom,
         disp_fine: $scope.freeTo
         };

         PostazioneService.api.spot.query(parametri,
         function (response) {
         drawMap(response);
         console.log("Map updated in " + (new Date() - t) + " ms");
         },
         function (error) {
         console.log("error: " + error);
         alert("Impossibile scaricare la lista delle postazioni");
         });
         */

        var parametri = {
            data: $scope.mapDate
        };

        PostazioneService.api.spot.query(parametri,
        function (response) {
            drawMap(response);
            console.log("Map updated in " + (new Date() - t) + " ms");
        },
        function (error) {
            console.log("error: " + error);
            alert("Impossibile scaricare la lista delle postazioni");
        });

    };

    $scope.edit = function (postazione, $event) {
        function success (data) {
            ;
        }

        function cancel () {
            console.log("Edit cancelled by user");
        }

        PostazioneService.edit($event, postazione, $scope.mapDate, success, cancel);

//        $mdDialog.show({
//            targetEvent: $event,
//            templateUrl: "views/forms/edit-postazione.html",
//            controller: "EditSpotCtrl",
//            locals: {
//                postazione: postazione,
//                dataInizio: $scope.mapDate
//            },
//            parent: angular.element(document.body),
//            escapeToClose: true
//        }).then(function (postazione) {
//            // TODO: Risposto ok, salvare la postazione
//            console.log(postazione);
//        }, function () {
//            // User cancelled edit
//            console.log("Edit cancelled");
//        });
    };

    $scope.options.show = function ($event) {
        $mdDialog.show({
            targetEvent: $event,
            templateUrl: "views/map/map-options.html",
            controller: "MapCtrl",
            bindToController: true,
            parent: angular.element(document.body),
            escapeToClose: true
        }).then(function (postazione) {
            // TODO: Risposto ok, salvare la postazione
            console.log(postazione);
        }, function () {
            // User cancelled edit
            console.log("Edit cancelled");
        });
    };

    $scope.options.cancel = function () {
        $mdDialog.cancel();
    };

    $scope.updateMap();
}
);
