// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

controllers.controller("EditServiceCostCtrl",
    function ($scope, $timeout, $mdDialog, ToastService, CostoServizioService, tipoServizio, costoServizio) {
        $scope.tipoServizio = tipoServizio;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;

        if (!angular.isObject(tipoServizio)) {
            console.error("$scope.tipoServizio è nullo. Impossibile continuare");
        }

        // Imposta pagamento e cliente
        if (angular.isObject(costoServizio)) {
            $scope.costoServizio = costoServizio;
            $scope.isUpdate = true;
        } else {
            $scope.costoServizio = CostoServizioService.new();
            $scope.costoServizio.idTipoServizio = $scope.tipoServizio.idTipoServizio;
            $scope.isUpdate = false;
        }

        $scope.confirm = function () {
            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.costoServizioForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    costoServizio: $scope.costoServizio
                });
            } else if ($scope.dirty === 0) {
                // New form, no data input. Ok to cancel form
                $mdDialog.cancel();
            } else if ($scope.costoServizioForm.$invalid) {
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

        $scope.changed = function () {
            console.log("Form changed @ " + new Date());

            // Track changes
            $scope.dirty++;

            if ($scope.costoServizioForm.$valid) {
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
                if (data.hasOwnProperty("idCosto")) {
                    $scope.costoServizio.idCosto = data.idCosto;
                }

                // Provide feedback
                ToastService.showSimpleToast("Servizio salvato");

                // Invoke the callback if provided
//            if (angular.isFunction($scope.success)) {
//                $scope.success($scope.costoServizio);
//            }
            }

            function _error(errordata) {
                console.error("Cannot save: " + JSON.stringify(errordata));
                ToastService.showSimpleToast("Errore. Servizio non salvato");

                // Invoke the callback if provided
//            if (angular.isFunction($scope.error)) {
//                $scope.error(errordata);
//            }
            }

            if ($scope.dirty === 0) {
                return;
            }

            if ($scope.isUpdate) {
                // Non è detto che l'oggetto abbia i metodi di $resource
                //model.tipoServizio.$update(successcb, errorcb);
                CostoServizioService.api.update(
                    {idCosto: $scope.costoServizio.idCosto},
                    $scope.costoServizio,
                    _success,
                    _error);
            } else {
                CostoServizioService.api.save(
                    $scope.costoServizio,
                    _success,
                    _error);
            }
        }
    });
