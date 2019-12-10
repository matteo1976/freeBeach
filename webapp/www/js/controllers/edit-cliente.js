// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

controllers.controller("EditCustomerCtrl",
    function ($scope, $mdDialog, $timeout, ToastService, ClienteService, AssegnamentoService,
        PagamentoService, cliente)
    {
        $scope.cliente = null;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;
        $scope.needRefreshAssegnamenti = true;

        // Imposta cliente
        if (angular.isObject(cliente) && cliente.hasOwnProperty("idCliente")
            && angular.isNumber(cliente.idCliente))
        {
            $scope.cliente = cliente;
            $scope.isUpdate = true;
        } else {
            $scope.cliente = ClienteService.new();
            $scope.isUpdate = false;
        }

        $scope.confirm = function () {
            // Forzo il profilo cliente
            $scope.cliente.idProfilo = 3;

            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.customerForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    cliente: $scope.cliente
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

        $scope.changed = function () {
            console.log("Form changed @ " + new Date());

            // Track changes
            $scope.dirty++;

            if ($scope.customerForm.$valid) {
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
                if (data.hasOwnProperty("idCliente")) {
                    $scope.cliente.idCliente = data.idCliente;
                }

                // Provide feedback
                ToastService.showSimpleToast("Cliente salvato");
            }

            function _error(errordata) {
                console.error("Cannot save: " + JSON.stringify(errordata));
                ToastService.showSimpleToast("Errore. cliente non salvato");
            }

            if ($scope.dirty === 0) {
                return;
            }

            if ($scope.isUpdate) {
                // Non è detto che l'oggetto abbia i metodi di $resource
                ClienteService.api.customers.update(
                    $scope.cliente,
                    _success,
                    _error);
            } else {
                ClienteService.api.customers.save(
                    $scope.cliente,
                    _success,
                    _error);
            }
        }

        // Titolo per la form
        $scope.getTitolo = function () {
            if (!angular.isObject($scope.cliente)) {
                return "Nuovo cliente";
            } else if (!angular.isString($scope.cliente.nome)) {
                return "Nuovo cliente";
            } else {
                return $scope.cliente.nome;
            }
        };

        $scope.assign = function ($event) {
            function success(data) {
                if (angular.isArray($scope.cliente.assegnamenti)) {
                    $scope.cliente.assegnamenti.push(data.assegnamento);
                } else {
                    $scope.cliente.assegnamenti = [data.assegnamento];
                }
            }

            function cancel() {}

            AssegnamentoService.edit($event, $scope.cliente, null, null, success, cancel);
        };

        $scope.editAssegnamento = function ($event, assegnamento) {
            function success(data) {}
            function cancel() {}

            AssegnamentoService.edit($event, $scope.cliente, assegnamento, assegnamento.postazione,
                success, cancel);
        };

        $scope.refreshAssegnamenti = function () {
            if ($scope.needRefreshAssegnamenti === false) {
                return;
            }

            ClienteService.api.customerSpots.query({
                idCliente: $scope.cliente.idCliente,
                dataInizio: new Date()
            }, function (data) {
                $scope.cliente.assegnamenti = data;
                $scope.needRefreshAssegnamenti = false;
                ToastService.showSimpleToast("Aggiornato assegnamenti");
            }, function (error) {
                console.log("error: " + error);
                ToastService.showSimpleToast("Assegnamenti non aggiornati");
            });
        };

        $scope.pay = function ($event) {
            function success(data) {
                if (angular.isArray($scope.cliente.pagamenti)) {
                    $scope.cliente.pagamenti.push(data.pagamento);
                } else {
                    $scope.cliente.pagamenti = [data.pagamento];
                }
            }

            function cancel() {}

            PagamentoService.edit($event, $scope.cliente, null, success, cancel);
        };

        $scope.editPagamento = function ($event, pagamento) {
            function success(data) {}
            function cancel() {}

            PagamentoService.edit($event, $scope.cliente, pagamento, success, cancel);
        };

        /*
         $scope.isEmailValid = function(){
         var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

         if ($scope.cliente.email === null)
         return true;
         else if ($scope.cliente.email === undefined)
         return true;
         else {
         return re.test($scope.cliente.email);
         }
         };
         */

        // TODO: Verificare se è opportuno lasciare la funzione
        /*
         $scope.remove = function () {
         if (confirm("Vuoi veramente cancellare il cliente " + $scope.cliente.nome + "?") === false)
         return;

         ClienteService.api.customers.delete({
         idCliente: $scope.cliente.idCliente
         },
         function (data) {
         console.trace("Deleted: " + JSON.stringify(data));
         // Passo il cliente modificato al chiamante
         $mdDialog.hide(null);
         debugger;
         },
         function (error) {
         console.error("Cannot delete: " + JSON.stringify(error));
         debugger;
         });
         };
         */
    }
);