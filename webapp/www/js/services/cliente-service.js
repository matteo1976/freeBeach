// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("ClienteService",
        function ($resource, $mdDialog, AssegnamentoService) {
            /**
             * Solleva un'eccezione su l'oggetto non è valido
             * @param {Cliente} cliente Oggetto da verificare
             */
            function _validate(cliente) {
                if (!angular.isObject(cliente)) {
                    throw "Invalid object";
                }
            }

            /**
             * Estende le funzionalità dell'oggetto Cliente restituito dall'API.
             * Metodi già presenti nell'oggetto non vengono ridefiniti dal decorator.
             * L'oggetto viene modificato per riferimento ma è anche restituito
             * dal metodo per supportare uno stile fluent.
             * @param {Cliente} L'oggetto Cliente da decorare. Se il paramerto
             * non è un oggetto valido viene sollevata un'eccezione "Invalid Object".
             * @returns {Cliente} L'oggetto modificato. Consente uno stile fluent
             * eseguendo un metodo direttamente sul cliente decorato.
             */
            function _decorate(cliente) {
                _validate(cliente);

                // Idrata gli assegnamenti
                if (angular.isArray(cliente.assegnamenti)) {
                    for (var i = 0; i < cliente.assegnamenti.length; i++) {
                        AssegnamentoService.hydrate(cliente.assegnamenti[i]);
                    }
                }

                /**
                 * cliente.getAssegnamento(date)
                 * Restituisce gli assegnamenti che soddisfano i criteri
                 * rispetto alla data fornita.
                 * criteria è un oggetto i cui attributi rappresentano un criterio di selezione.
                 * I criteri riconosciuti sono: current, next, future, past
                 */
                if (!cliente.hasOwnProperty("getAssegnamenti")) {
                    cliente.getAssegnamenti = function (criteria, date) {
                        if (!angular.isObject(cliente.assegnamenti))
                            return [];

                        if (!angular.isObject(criteria))
                            return []; // TODO: sarebbe un errore

                        if (!angular.isDate(date))
                            date = new Date();

                        var results = [];

                        for (var i = 0; i < cliente.assegnamenti.length; i++) {
                            var a = cliente.assegnamenti[i];

                            if (criteria.hasOwnProperty("current") && criteria.current) {
                                if (a.dataInizio <= date && a.dataFine >= date) {
                                    return [a];
                                }
                            }

                            if (criteria.hasOwnProperty("next") && criteria.next) {
                                if (a.dataInizio > date) {
                                    if (results.length === 0) {
                                        results.push(a);
                                    } else if (a.dataInizio < results[0].dataInizio) {
                                        results[0] = a;
                                    }
                                }
                            }

                            if (criteria.hasOwnProperty("future") && criteria.future) {
                                if (a.dataInizio > date) {
                                    results.push(a);
                                }
                            }

                            if (criteria.hasOwnProperty("past") && criteria.past) {
                                if (a.dataFine < date) {
                                    results.push(a);
                                }
                            }
                        }

                        return results;
                    };
                }

                if (!cliente.hasOwnProperty("isNew")) {
                    cliente.isNew = function () {
                        return cliente.idCliente === null;
                    };
                }

                if (!cliente.hasOwnProperty("hasAssegnamenti")) {
                    cliente.hasAssegnamenti = function () {
                        return angular.isObject(cliente.assegnamenti) && cliente.assegnamenti.length > 0;
                    };
                }

                if (!cliente.hasOwnProperty("hasPagamenti")) {
                    cliente.hasPagamenti = function () {
                        return angular.isObject(cliente.pagamenti) && cliente.pagamenti.length > 0;
                    };
                }

                if (!cliente.hasOwnProperty("hasIndirizzo")) {
                    cliente.hasIndirizzo = function () {
                        return angular.isString(cliente.indirizzo)
                            || angular.isString(cliente.cap)
                            || angular.isString(cliente.citta)
                            || angular.isString(cliente.provincia)
                            || angular.isString(cliente.stato);
                    };
                }

                if (!cliente.hasOwnProperty("hasTelefono")) {
                    cliente.hasTelefono = function () {
                        return angular.isString(cliente.telefono);
                    };
                }

                if (!cliente.hasOwnProperty("hasEmail")) {
                    cliente.hasEmail = function () {
                        return angular.isString(cliente.email);
                    };
                }

                return cliente;
            }

            /**
             * Restituisce un nuovo oggetto Cliente.
             * @returns {Postazione}
             */
            function _new() {
                var cliente = {
                    idCliente: null,
                    nome: null,
                    indirizzo: null,
                    cap: null,
                    citta: null,
                    provincia: null,
                    stato: null,
                    telefono: null,
                    codiceFiscale: null,
                    email: null,
                    password: null,
                    abilitato: false,
                    daSaldare: 0,
                    note: null,
                    profilo: null, //Profilo { }
                    schede: [],
                    assegnamenti: [],
                    pagamenti: []
                };

                return this.decorate(cliente);
            }

            function _apiCustomers(resource) {
                return resource(_buildURL("clienti/:idCliente"), {
                    idCliente: "@idCliente"
                }, {
                    update: {method: "PUT"}
                });
            }

            function _apiCustomerSpots(resource) {
                return resource(_buildURL("clienti/:idCliente/postazioni/:idPostazione"), {
                    idCliente: "@idCliente",
                    idPostazione: "@idPostazione"
                }, {
                    update: {method: "PUT"}
                });
            }

            function _apiCustomerCards(resource) {
                return resource(_buildURL("clienti/:idCliente/schede/:idScheda"), {
                    idCliente: "@idCliente",
                    idScheda: "@idScheda"
                }, {
                    update: {method: "PUT"}
                });
            }

            function _edit($event, cliente, success, cancel) {
                $mdDialog.show({
                    targetEvent: $event,
                    templateUrl: "views/forms/edit-cliente.html",
                    controller: "EditCustomerCtrl",
                    locals: {
                        cliente: cliente
                    },
                    parent: angular.element(document.body),
                    multiple: true,
                    escapeToClose: true
                }).then(function (data) {
                    // Invoke the callback if provided
                    if (angular.isFunction(success)) {
                        success(data);
                    }
                }, function () {
                    console.log("User cancelled edit");

                    // Invoke the callback if provided
                    if (angular.isFunction(cancel)) {
                        cancel();
                    }
                });
            }

            return {
                decorate: _decorate,
                new: _new,
                edit: _edit,
                api: {
                    customers: _apiCustomers($resource),
                    customerCards: _apiCustomerCards($resource),
                    customerSpots: _apiCustomerSpots($resource)
                }
            };
        });

})();
