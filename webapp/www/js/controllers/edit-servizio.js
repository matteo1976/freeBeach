// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

controllers.controller("EditServiceCtrl",
    function ($scope, $timeout, $mdDialog, ToastService, ServizioService, TipoServizioService,
        servizio, assegnamento, postazione)
    {
        $scope.servizio = null;
        $scope.assegnamento = assegnamento;
        $scope.postazione = postazione;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;

        $scope.acTipoServizio = {
            text: null,
            readOnly: false,
            data: null,
            find: function () {
                return TipoServizioService.api.query({
                    filtro: $scope.acTipoServizio.text
                }, function (data) {
                    return data;
                }, function (error) {
                    console.error(error);
                });
            }
        };

        if (angular.isObject(servizio)) {
            $scope.servizio = servizio;
            $scope.isUpdate = true;
        } else {
            $scope.servizio = ServizioService.new();
            $scope.servizio.idAssegnamento = $scope.assegnamento.idAssegnamento;
            $scope.isUpdate = false;
        }

        if (angular.isObject($scope.servizio.tipoServizio)) {
            $scope.acTipoServizio.data = $scope.servizio.tipoServizio;
        } else {
            $scope.acTipoServizio.data = null;
        }

        $scope.confirm = function () {
            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.servizioForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    servizio: $scope.servizio
                });
            } else if ($scope.dirty === 0) {
                // New form, no data input. Ok to cancel form
                $mdDialog.cancel();
            } else if ($scope.servizioForm.$invalid) {
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

            if ($scope.servizio.idTipoServizio !== $scope.acTipoServizio.data.idTipoServizio) {
                $scope.servizio.idTipoServizio = $scope.acTipoServizio.data.idTipoServizio;
                $scope.servizio.tipoServizio = $scope.acTipoServizio.data;
            }

            if ($scope.servizioForm.$valid) {
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
                if (data.hasOwnProperty("idServizio")) {
                    $scope.servizio.idServizio = data.idServizio;
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
                //model.servizio.$update(successcb, errorcb);
                ServizioService.api.update(
                    {
                        idPostazione: $scope.postazione.idPostazione,
                        idAssegnamento: $scope.servizio.idAssegnamento,
                        idServizio: $scope.servizio.idServizio
                    },
                    $scope.servizio,
                    _success,
                    _error);
            } else {
                ServizioService.api.save(
                    {
                        idPostazione: $scope.postazione.idPostazione,
                        idAssegnamento: $scope.servizio.idAssegnamento
                    },
                    $scope.servizio,
                    _success,
                    _error);
            }
        }
    }
);
