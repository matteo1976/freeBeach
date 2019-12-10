"use strict";

var controllers = angular.module("controllers");

/*
 * Non blocco mai l'edit di postazione e cliente.
 * Possono sempre essere modficati. È responsabilità
 * del chiamante gestire cambi cliente o postazione.
 */
controllers.controller("EditPaymentCtrl",
    function ($scope, $mdDialog, $timeout, ToastService, ClienteService, PagamentoService, cliente, pagamento)
    {
        $scope.pagamento = null;
        $scope.aggiornaDebito = null;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;

        // Imposta pagamento
        if (angular.isObject(pagamento)) {
            $scope.pagamento = pagamento;
            $scope.isUpdate = true;
        } else {
            $scope.pagamento = PagamentoService.new();
            $scope.pagamento.data = new Date();
            $scope.isUpdate = false;
            $scope.aggiornaDebito = true;
        }

        // Imposta cliente
        if (angular.isObject(cliente) && cliente.hasOwnProperty("idCliente")
            && angular.isNumber(cliente.idCliente))
        {
            $scope.cliente = cliente;
        } else {
            console.alert("Il cliente è richiesto");
        }

        $scope.changed = function () {
            console.log("Form changed @ " + new Date());

            // Track changes
            $scope.dirty++;

            if ($scope.paymentForm.$valid) {
                if (angular.isObject($scope.willSave)) {
                    $timeout.cancel($scope.willSave);
                }
                // TODO: Definire una costante nel modulo app
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
                if (data.hasOwnProperty("idPagamento")) {
                    $scope.pagamento.idPagamento = data.idPagamento;
                }

                // Provide feedback
                ToastService.showSimpleToast("Pagamento salvato");
            }

            function _error(errordata) {
                console.error("Cannot save: " + JSON.stringify(errordata));
                ToastService.showSimpleToast("Errore. Pagamento non salvato");
            }

            if ($scope.dirty === 0) {
                return;
            }

            if ($scope.isUpdate) {
                // Non è detto che l'oggetto abbia i metodi di $resource
                PagamentoService.api.update(
                    {
                        idCliente: $scope.cliente.idCliente,
                        aggiornaDebito: $scope.aggiornaDebito
                    },
                    $scope.pagamento,
                    _success,
                    _error);
            } else {
                PagamentoService.api.save(
                    {
                        idCliente: $scope.cliente.idCliente,
                        aggiornaDebito: $scope.aggiornaDebito
                    },
                    $scope.pagamento,
                    _success,
                    _error);
            }
        }

        $scope.confirm = function () {
            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.paymentForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    pagamento: $scope.pagamento,
                    aggiornaDebito: $scope.aggiornaDebito
                });
            } else if ($scope.dirty === 0) {
                // New form, no data input. Ok to cancel form
                $mdDialog.cancel();
            } else if ($scope.customerForm.$invalid) {
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
    }
);
