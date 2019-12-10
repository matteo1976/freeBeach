// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var controllers = angular.module("controllers");

    controllers.controller("AppCtrl",
        function ($scope, $location, $mdDialog, $mdToast, ClienteService, AssegnamentoService, TipoServizioService) {

            /**
             * Funzionalità generali del box comandi specializzabile per view
             */
            $scope.viewCommandBox = {
                _open: false,
                flip: function () {
                    $scope.viewCommandBox._open = !$scope.viewCommandBox._open;
                },
                isOpen: function () {
                    return $scope.viewCommandBox._open === true;
                },
                isClosed: function () {
                    return $scope.viewCommandBox._open === false;
                }
            };

            /**
             * Attiva la view della mappa
             * @returns No return value
             */
            $scope.map = function () {
                $location.url("/map");
            };

            /**
             * Attiva la view della ricerca
             * @returns No return value
             */
            $scope.cerca = function () {
                $location.url("/omni-search");
            };

            /**
             * Crea un cliente.
             * @param {type} $event
             * @returns No value returned
             */
            $scope.addCliente = function ($event) {
                ClienteService.edit($event, null);
            };

// Disabilitato. Non posso aggiornare la postazione che sta in un altro controller.
// Così si crea un'incongruenza tra lo stato reale e quello rappresentato sulla mappa.
//            /**
//             * Crea un assegnamento senza preimpostare cliente ne postazione.
//             * @param {type} $event
//             * @returns No value returned
//             */
//            $scope.addAssegnamento = function ($event) {
//                AssegnamentoService.edit($event);
//            };

            $scope.addScheda = function () {
                console.log("You clicked addScheda.");
                alert("Implementa l'anagrafica scheda");
            };
            $scope.addOperatore = function () {
                console.log("You clicked addOperatore.");
                alert("Implementa l'anagrafica operatore");
            };

            $scope.addAbbonamento = function () {
                console.log("You clicked addAbbonamento.");
                alert("Implementa l'anagrafica abbonamento");
            };

            $scope.addTipoServizio = function ($event) {
                TipoServizioService.edit($event);
            };
        });

})();
