// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

controllers.controller("EditServiceTypeCtrl",
    function ($scope, $timeout, $mdDialog, ToastService, TipoServizioService, CostoServizioService, tipoServizio)
    {
        $scope.tipoServizio = null;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;

        // Imposta pagamento e cliente
        if (angular.isObject(tipoServizio)) {
            $scope.tipoServizio = tipoServizio;
            $scope.isUpdate = true;
        } else {
            $scope.tipoServizio = TipoServizioService.new();
            $scope.isUpdate = false;
        }

        $scope.confirm = function () {
            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.tipoServizioForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    tipoServizio: $scope.tipoServizio
                });
            } else if ($scope.dirty === 0) {
                // New form, no data input. Ok to cancel form
                $mdDialog.cancel();
            } else if ($scope.tipoServizioForm.$invalid) {
                // Cannot save invalid data, really cancel form?
                if (confirm(msg) === false) {
                    return;
                } else {
                    $mdDialog.cancel();
                }
            } else {
                // Save failed. WTF?
                if (confirm(msg) === false) {
                    return;
                } else {
                    $mdDialog.cancel();
                }
            }
        };

        $scope.addCost = function ($event) {
            CostoServizioService.edit($event, $scope.tipoServizio, undefined,
                function (data) {
                    // Success - Aggiungo il costo alla lista
                    $scope.tipoServizio.addCosto(data.costoServizio);
                },
                function () {
                    console.log("User cancelled edit");
                });
        };

        $scope.editCost = function ($event, costoServizio) {
            CostoServizioService.edit($event, tipoServizio, costoServizio);
        };

        $scope.changed = function () {
            console.log("Form changed @ " + new Date());

            // Track changes
            $scope.dirty++;

            if ($scope.tipoServizioForm.$valid) {
                if (angular.isObject($scope.willSave)) {
                    $timeout.cancel($scope.willSave);
                }
                $scope.willSave = $timeout(save, 1000);
            }
        };

        function save() {
            function _success(data) {
                console.log("Saved @ " + new Date() + " : " + JSON.stringify(data));

                // Reset the change count
                $scope.dirty = 0;

                // Clear the save promise
                $scope.willSave = null;

                // Next time updates the same object
                $scope.isUpdate = true;

                // Update the id with value provided by the API
                if (data.hasOwnProperty("idTipoServizio")) {
                    $scope.tipoServizio.idTipoServizio = data.idTipoServizio;
                }

                // Provide feedback
                ToastService.showSimpleToast("Servizio salvato");
            }

            function _error(errordata) {
                console.error("Cannot save: " + JSON.stringify(errordata));
                ToastService.showSimpleToast("Errore. Servizio non salvato");
            }

            if ($scope.dirty === 0) {
                return;
            }

            if ($scope.isUpdate) {
                // Non è detto che l'oggetto abbia i metodi di $resource
                //model.tipoServizio.$update(successcb, errorcb);
                TipoServizioService.api.update(
                    {idTipoServizio: $scope.tipoServizio.idTipoServizio},
                    $scope.tipoServizio,
                    _success,
                    _error);
            } else {
                TipoServizioService.api.save(
                    $scope.tipoServizio,
                    _success,
                    _error);
            }
        }
    }
);
