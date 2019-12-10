"use strict";

var controllers = angular.module("controllers");

controllers.controller("EditSpotCtrl",
    function ($scope, $mdDialog, $timeout, ToastService, PostazioneService, AssegnamentoService, postazione, dataInizio) {
        $scope.postazione = null;
        $scope.primoAssegnamento = null;
        $scope.isUpdate = null;
        $scope.dirty = 0;
        $scope.willSave = null;
        $scope.needRefreshAssegnamenti = true;

        $scope.hasPrimoAssegnamento = function () {
            return $scope.primoAssegnamento !== null;
        };

        // Imposta postazione e assegnamenti
        if (angular.isObject(postazione)) {
            $scope.postazione = postazione;
            $scope.primoAssegnamento = postazione.getPrimoAssegnamento();
            $scope.isUpdate = true;
        } else {
            $scope.postazione = PostazioneService.new();
            $scope.isUpdate = false;
        }

        $scope.confirm = function () {
            var msg = "Non posso salvare i dati perché sono incompleti o non validi. "
                + "Uscendo li perderai. Continuo?";

            if ($scope.postazioneForm.$valid && $scope.dirty === 0) {
                // Data saved, ok to confirm form
                $mdDialog.hide({
                    postazione: $scope.postazione
                });
            } else if ($scope.dirty === 0) {
                // New form, no data input. Ok to cancel form
                $mdDialog.cancel();
            } else if ($scope.postazioneForm.$invalid) {
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

            if ($scope.postazioneForm.$valid) {
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
                if (data.hasOwnProperty("idPostazione")) {
                    $scope.postazione.idPostazione = data.idPostazione;
                }

                // Provide feedback
                ToastService.showSimpleToast("Postazione salvata");
            }

            function _error(errordata) {
                console.error("Cannot save: " + JSON.stringify(errordata));
                ToastService.showSimpleToast("Errore. Postazione non salvata");
            }

            if ($scope.dirty === 0) {
                return;
            }

            if ($scope.isUpdate) {
                // Non è detto che l'oggetto abbia i metodi di $resource
                //model.tipoServizio.$update(successcb, errorcb);
                PostazioneService.api.spot.update(
                    $scope.postazione.toSwagger(),
                    _success,
                    _error);
            } else {
                PostazioneService.api.spot.save(
                    $scope.postazione,
                    _success,
                    _error);
            }
        }

        $scope.assign = function ($event) {
            function success(data) {
                AssegnamentoService.api.query(
                    {
                        idPostazione: $scope.postazione.idPostazione,
                        dataInizio: dataInizio
                    },
                    function (data) {
                        $scope.postazione.assegnamenti = data;
                    },
                    function (error) {
                        console.log(JSON.stringify(error));

                        // Cannot refresh assignment list, just adding assignment
                        if (!angular.isArray($scope.postazione.assegnamenti)) {
                            $scope.postazione.assegnamenti = [];
                        }

                        $scope.postazione.assegnamenti.push(data.assegnamento);
                    }
                );
            }

            function cancel() {}

            AssegnamentoService.edit($event, null, null, $scope.postazione, success, cancel);
        };

        $scope.editAssegnamento = function (assegnamento, $event) {
            function success(data) {
                // TODO: fix circular object reference
                // console.trace("Saved: " + JSON.stringify(data));
                console.trace("Saved");
            }

            function cancel() {}

            AssegnamentoService.edit($event, assegnamento.cliente,
                assegnamento, $scope.postazione, success, cancel);
        };

        $scope.refreshAssegnamenti = function () {
            if ($scope.needRefreshAssegnamenti === false) {
                return;
            }

            AssegnamentoService.api.query({
                idPostazione: $scope.postazione.idPostazione,
                dataInizio: new Date()
            }, function (data) {
                $scope.postazione.assegnamenti = data;
                $scope.needRefreshAssegnamenti = false;
                ToastService.showSimpleToast("Aggiornato assegnamenti");
            }, function (error) {
                console.log("error: " + error);
                ToastService.showSimpleToast("Assegnamenti non aggiornati");
            });
        };

    }
);



