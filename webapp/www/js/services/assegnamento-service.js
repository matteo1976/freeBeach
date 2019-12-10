// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("AssegnamentoService", function ($resource, $mdDialog) {
        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {AssegnamentoPostazione} assegnamento Oggetto da verificare
         */
        function _validate(assegnamento) {
            if (!angular.isObject(assegnamento)) {
                throw "Invalid object";
            }
        }

        function _decorate(assegnamento) {
            _validate(assegnamento);

            if (!assegnamento.hasOwnProperty("toSwagger")) {
                assegnamento.toSwagger = function (postazione) {
                    if (postazione === undefined && angular.isObject(assegnamento.postazione)) {
                        postazione = assegnamento.postazione;
                    }

                    return {
                        idAssegnamento: assegnamento.idAssegnamento,
                        idCliente: assegnamento.cliente.idCliente,
                        idPostazione: postazione.idPostazione,
                        idAbbonamento: assegnamento.abbonamento.idAbbonamento,
                        dataInizio: assegnamento.dataInizio,
                        dataFine: assegnamento.dataFine,
                        autorizzati: assegnamento.autorizzati,
                        note: assegnamento.note
                    };
                };
            }

            if (!assegnamento.hasOwnProperty("hasServizi")) {
                assegnamento.hasServizi = function () {
                    if (!angular.isArray(assegnamento.servizi)) {
                        return false;
                    }

                    if (assegnamento.servizi.length === 0) {
                        return false;
                    }

                    return true;
                };
            }

            if (!assegnamento.hasOwnProperty("hasAutorizzati")) {
                assegnamento.hasAutorizzati = function () {
                    if (!angular.isString(assegnamento.autorizzati)) {
                        return false;
                    }

                    if (assegnamento.autorizzati.trim().length === 0) {
                        return false;
                    }

                    return true;
                };
            }

            if (!assegnamento.hasOwnProperty("hasNote")) {
                assegnamento.hasNote = function () {
                    if (!angular.isString(assegnamento.note)) {
                        return false;
                    }

                    if (assegnamento.note.trim().length === 0) {
                        return false;
                    }

                    return true;
                };
            }

            return assegnamento;
        }

        /**
         * Applicata a un oggetto restituito dall'API, converte i dati forniti
         * in oggetti nativi. In particolare, data inizio e data fine.
         * L'oggetto viene modificato per riferimento ma è anche restituito
         * dal metodo per supportare uno stile fluent.
         * @param {AssegnamentoPostazione} assegnamento
         * @returns {AssegnamentoPostazione}
         */
        function _hydrate(assegnamento) {
            _validate(assegnamento);

            if (angular.isString(assegnamento.dataInizio)) {
                assegnamento.dataInizio = new Date(assegnamento.dataInizio);
            }

            if (angular.isString(assegnamento.dataFine)) {
                assegnamento.dataFine = new Date(assegnamento.dataFine);
            }

            return _decorate(assegnamento);
        }

        /**
         * Restituisce un nuovo oggetto che rappresenta il periodo in cui il
         * cliente ha noleggiato la postazione.
         * @returns {AssegnamentoPostazione}
         */
        function _new() {
            var assegnamento = {
                idAssegnamento: null,
                postazione: null,
                cliente: null,
                abbonamento: null,
                dataInizio: null,
                dataFine: null,
                note: null,
                autorizzati: null,
                disponibilita: [],
                servizi: []
            };

            return _decorate(assegnamento);
        }

        function _edit($event, cliente, assegnamento, postazione, success, cancel) {
            $mdDialog.show({
                targetEvent: $event,
                templateUrl: "views/forms/edit-assegnamento.html",
                controller: "EditAssignmentCtrl",
                locals: {
                    cliente: cliente,
                    assegnamento: assegnamento,
                    postazione: postazione
                },
                parent: angular.element(document.body),
                multiple: true,
                escapeToClose: true
            })
            .then(function (data) {
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

        function _api($resource) {
            return $resource(_buildURL("postazioni/:idPostazione/assegnamenti/:idAssegnamento"), {
                idPostazione: "@idPostazione",
                idAssegnamento: "@idAssegnamento"
            }, {
                update: {method: "PUT"}
            });
        }

        return {
            hydrate: _hydrate,
            new : _new,
            edit: _edit,
            api: _api($resource)
        };
    });

    // Periodo in cui la postazione era disponibile
    // ed è stata riaffittata ad un altro cliente
    var SubaffittoPostazione = function () {
        this.dataInizio = null;
        this.dataFine = null;
    };

    // Periodo in cui il cliente consente che la postazione
    // sia riaffittata ad altri
    var DisponibilitaPostazione = function () {
        this.dataInizio = null;
        this.dataFine = null;
        this.subaffitti = [];
    };

})();
