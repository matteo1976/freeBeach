// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

/*
 * Non blocco mai l'edit di postazione e cliente.
 * Possono sempre essere modficati. È responsabilità
 * del chiamante gestire cambi cliente o postazione.
 */
controllers.controller("EditAssignmentCtrl",
    function ($scope, $timeout, $mdDialog, ToastService, AssegnamentoService, ClienteService,
        PostazioneService, AbbonamentoService, ServizioService, assegnamento, cliente, postazione)
    {
        $scope.assegnamento = null;
        $scope.abbonamenti = null;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;
        $scope.needRefreshServizi = true;

        AbbonamentoService.api.query({
        }, function (data) {
            $scope.abbonamenti = data;
        }, function (error) {
            console.error(error);
            debugger;
        });

        $scope.acCliente = {
            text: null,
            readOnly: false,
            data: null,
            find: function () {
                return ClienteService.api.customers.query({
                    filtro: $scope.acCliente.text
                }, function (data) {
                    return data;
                }, function (error) {
                    console.error(error);
                });
            }
        };

        $scope.acPostazione = {
            text: null,
            readOnly: false,
            data: null,
            find: function () {
                // Parse input text and split row/column
                var coord = PostazioneService.parse($scope.acPostazione.text);

                if (coord === null) {
                    alert("Testo non valido");
                    return;
                }

                var parameters = {};

                if (angular.isDefined(coord.row))
                    parameters.fila = coord.row;
                if (angular.isDefined(coord.col))
                    parameters.colonna = coord.col;

                return PostazioneService.api.spot.query(
                    parameters,
                    function (data) {
                        for (var i = 0; i < data.length; i++)
                            PostazioneService.decorate(data[i]);
                        return data;
                    }, function (error) {
                    console.error(error);
                });
            }
        };

        // Imposta assegnamento e cliente
        if (angular.isObject(assegnamento)) {
            AssegnamentoService.hydrate(assegnamento);
            $scope.assegnamento = assegnamento;
            $scope.isUpdate = true;

            if (angular.isObject(cliente)) {
                $scope.acCliente.data = cliente;
            } else {
                $scope.acCliente.data = assegnamento.cliente;
            }
        } else {
            $scope.assegnamento = AssegnamentoService.new();
            $scope.assegnamento.dataInizio = new Date();
            $scope.assegnamento.dataFine = new Date();
            $scope.isUpdate = false;

            if (angular.isObject(cliente)) {
                $scope.acCliente.data = cliente;
            } else {
                $scope.acCliente.data = null;
            }
        }

        // Imposta la postazione
        if (angular.isObject(postazione)) {
            if (!postazione.hasOwnProperty("getCode")) {
                PostazioneService.decorate(postazione);
            }
            $scope.acPostazione.data = postazione;
        } else {
            $scope.acPostazione.data = null;
        }

        $scope.confirm = function () {
            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.assegnamentoForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    assegnamento: $scope.assegnamento
                });
            } else if ($scope.dirty === 0) {
                // New form, no data input. Ok to cancel form
                $mdDialog.cancel();
            } else if ($scope.assegnamentoForm.$invalid) {
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

            if ($scope.assegnamentoForm.$invalid) {
                return;
            }

            if ($scope.assegnamentoForm.inputCliente.$invalid
                || $scope.assegnamentoForm.inputCliente.$modelValue === null
                || $scope.assegnamentoForm.inputCliente.$modelValue === "")
            {
                return;
            }

            if ($scope.assegnamentoForm.inputPostazione.$invalid
                || $scope.assegnamentoForm.inputPostazione.$modelValue === null
                || $scope.assegnamentoForm.inputPostazione.$modelValue === "")
            {
                return;
            }

            if (angular.isObject($scope.willSave)) {
                $timeout.cancel($scope.willSave);
            }

            $scope.willSave = $timeout(save, 1000);
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
                if (data.hasOwnProperty("idAssegnamento")) {
                    $scope.assegnamento.idAssegnamento = data.idAssegnamento;
                }

                // Provide feedback
                ToastService.showSimpleToast("Assegnamento salvato");
            }

            function _error(errordata) {
                console.error("Cannot save: " + JSON.stringify(errordata));

                // Provide feedback
                ToastService.showSimpleToast("Errore. Assegnamento non salvato");
            }

            $scope.assegnamento.cliente = $scope.acCliente.data;
            $scope.assegnamento.postazione = $scope.acPostazione.data;
            var assegnamento = $scope.assegnamento.toSwagger();

            if ($scope.isUpdate) {
                // Non è detto che l'oggetto abbia i metodi di $resource
                //model.tipoServizio.$update(successcb, errorcb);
                AssegnamentoService.api.update(
                    {
                        idAssegnamento: assegnamento.idAssegnamento,
                        idPostazione: assegnamento.idPostazione
                    },
                    assegnamento,
                    _success,
                    _error);
            } else {
                AssegnamentoService.api.save(
                    assegnamento,
                    _success,
                    _error);
            }
        }

        $scope.addService = function ($event) {
            function success(data) {
                if (angular.isArray($scope.assegnamento.servizi)) {
                    $scope.assegnamento.servizi.push(data.servizio);
                } else {
                    $scope.assegnamento.servizi = [data.servizio];
                }

            }
            function cancel() {}

            ServizioService.edit(
                $event,
                null, // servizio
                $scope.assegnamento,
                $scope.acPostazione.data,
                success,
                cancel);
        };

        $scope.editService = function ($event, servizio) {
            function success(data) {}
            function cancel() {}

            ServizioService.edit(
                $event,
                servizio,
                $scope.assegnamento,
                $scope.acPostazione.data,
                success,
                cancel);
        };

        $scope.refreshServizi = function () {
            if ($scope.needRefreshServizi === false) {
                return;
            }

            ServizioService.api.query({
                idPostazione: $scope.acPostazione.data.idPostazione,
                idAssegnamento: $scope.assegnamento.idAssegnamento
            }, function (data) {
                $scope.assegnamento.servizi = data;
                $scope.needRefreshServizi = false;
                ToastService.showSimpleToast("Aggiornato servizi");
            }, function (error) {
                console.log("error: " + error);
                ToastService.showSimpleToast("Servizi non aggiornati");
            });
        };
    }
);