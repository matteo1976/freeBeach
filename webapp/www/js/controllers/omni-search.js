// vim: set ts=4 sw=4 expandtab:
"use strict";

var controllers = angular.module("controllers");

controllers.controller("OmniSearchCtrl",
function ($scope, $timeout, $mdDialog, $mdPanel, PostazioneService, ClienteService, AbbonamentoService, OperatoreService, TipoServizioService) {
    $scope.self = this;
    $scope.text = "";
    $scope.promise = null;
    $scope.mdDialog = $mdDialog;
    $scope.mdPanel = $mdPanel;

    function SearchControl(enabled) {
        this.switch = enabled;
        this.data = null;
        this.isVisible = function () {
            if (this.data !== null) {
                return this.switch && this.data.length > 0;
            } else {
                return this.switch;
            }
        };
        this.off = function () {
            this.switch = false;
            this.data = null;
        };
        this.on = function () {
            this.switch = false;
            if ($scope.text !== "")
                ;
        };
    }

    $scope.clienti = new SearchControl(true);
    $scope.postazioni = new SearchControl(false);
    $scope.carte = new SearchControl(false);
    $scope.operatori = new SearchControl(false);
    $scope.abbonamenti = new SearchControl(false);
    $scope.servizi = new SearchControl(true);

    $scope.search = function () {
        if ($scope.promise !== null) {
            $timeout.cancel($scope.promise);
        }

        if ($scope.text.length < 2) {
            return;
        }

        $scope.promise = $timeout(function () {
            if ($scope.postazioni.switch) {
                PostazioneService.api.spot.query({},
                function (response) {
                    $scope.postazioni.data = response;
                },
                function (error) {
                    console.log("error: " + error);
                    alert("Impossibile scaricare la lista delle postazioni");
                });
            }

            if ($scope.clienti.switch) {
                ClienteService.api.customers.query({
                    filtro: $scope.text
                }, function (response) {
                    for (var i = 0; i < response.length; i++) {
                        ClienteService.decorate(response[i]);
                    }
                    $scope.clienti.data = response;
                }, function (error) {
                    console.log("error: " + error);
                    alert("Impossibile scaricare la lista dei clienti");
                });
            }

            if ($scope.operatori.switch) {
                OperatoreService.api.query({
                    filtro: $scope.text
                }, function (response) {
                    $scope.operatori.data = response;
                }, function (error) {
                    console.log("error: " + error);
                    alert("Impossibile scaricare la lista degli operatori");
                });
            }

            if ($scope.abbonamenti.switch) {
                AbbonamentoService.api.query({
                    filtro: $scope.text
                }, function (response) {
                    $scope.abbonamenti.data = response;
                }, function (error) {
                    console.log("error: " + error);
                    alert("Impossibile scaricare la lista degli abbonamenti");
                });
            }

            if ($scope.servizi.switch) {
                TipoServizioService.api.query({
                    filtro: $scope.text,
                    filtroDati: new Date()
                }, function (response) {
                    for (var i = 0; i < response.length; i++) {
                        TipoServizioService.decorate(response[i]);
                    }
                    $scope.servizi.data = response;
                }, function (error) {
                    console.log("error: " + error);
                    alert("Impossibile scaricare la lista dei servizi");
                });
            }
        }, 500);
    };

    $scope.config = {
        dialog: null,
        open: function ($event) {
            $scope.config.dialog = $scope.mdDialog.show({
                contentElement: "#omni-search-config-dialog",
                parent: angular.element(document.body),
                scope: $scope,
                preserveScope: true,
                clickOutsideToClose: true,
                escapeToClose: true,
                targetEvent: $event,
                openFrom: "#omni-search .config-button",
                closeTo: "#omni-search .config-button"
            });
        },
        close: function () {
            $scope.mdDialog.hide($scope.config.dialog);
            $scope.config.dialog = null;
        }
    };

    $scope.editCliente = function (cliente, $event) {
        $mdDialog.show({
            targetEvent: $event,
            templateUrl: "views/forms/edit-cliente.html",
            controller: "EditCustomerCtrl",
            // Binding tra il cliente dello $scope e l'istanza della dialog
            bindToController: false,
            locals: {
                cliente: cliente
            },
            parent: angular.element(document.body),
            multiple: true,
            escapeToClose: true
        }).then(function (data) {
            cliente = data.cliente;
        }, function () {
            console.trace("User cancelled edit");
        });
    };

    $scope.editTipoServizio = function ($event, tipoServizio) {
        TipoServizioService.edit($event, tipoServizio);
    };
}
);


