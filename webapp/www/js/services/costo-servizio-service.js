// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("CostoServizioService", function ($resource, $mdDialog) {

        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {CostoServizio} costoServizio Oggetto da verificare
         */
        function _validate(costoServizio) {
            if (!angular.isObject(costoServizio)) {
                throw "Invalid object";
            }
        }

        /**
         * Applicata a un oggetto restituito dall'API, converte i dati forniti
         * in oggetti nativi. In particolare, data inizio e data fine.
         * L'oggetto viene modificato per riferimento ma è anche restituito
         * dal metodo per supportare uno stile fluent.
         * @param {CostoServizio} assegnamento
         * @returns {CostoServizio}
         */
        function _hydrate(costoServizio) {
            _validate(costoServizio);

            if (angular.isString(costoServizio.dataInizio)) {
                costoServizio.dataInizio = new Date(costoServizio.dataInizio);
            }

            if (angular.isString(costoServizio.dataFine)) {
                costoServizio.dataFine = new Date(costoServizio.dataFine);
            }

            return costoServizio;
        }

        /**
         * Restituisce un nuovo oggetto.
         * @returns {CostoServizio}
         */
        function _new() {
            var costoServizio = {
                idCosto: null,
                idTipoServizio: null,
                inizioPeriodo: null,
                finePeriodo: null,
                costo: null
            };

            //return _decorate(costoServizio);
            return costoServizio;
        }

        function _api() {
            return $resource(_buildURL("tipiServizio/:idTipoServizio/costiServizio/:idCosto"), {
                idTipoServizio: "@idTipoServizio",
                idCosto: "@idCosto"
            }, {
                update: {method: "PUT"}
            });
        }

//        function _decorate(tipoServizio) {
//            _validate(tipoServizio);
//
//            if (!tipoServizio.hasOwnProperty("hasCosti")) {
//                tipoServizio.hasCosti = function () {
//                    return angular.isArray(tipoServizio.costi) && tipoServizio.costi.length > 0;
//                };
//            }
//        }

        /**
         * Apre la form dell'anagrafica costo servizio e gestisce la memorizzazione
         * del valore inserito o modificato dall'utente. Per convenzione l'inserimento
         * viene eseguito *solo* se il parametro costoServizio è nullo.
         * @param {type} $event
         * @param {type} tipoServizio
         * @param {type} costoServizio NULL per creare un costo, l'oggetto per la modifica
         * @param {type} success Callback invocata dopo aver salvato il costo
         * @param {type} cancel Callback invocata quando l'utente annulla la form
         */
        function _edit($event, tipoServizio, costoServizio, success, cancel) {
            $mdDialog.show({
                targetEvent: $event,
                templateUrl: "views/forms/edit-costo-servizio.html",
                controller: "EditServiceCostCtrl",
                locals: {
                    tipoServizio: tipoServizio,
                    costoServizio: costoServizio
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

        return {
            new : _new,
            hydrate: _hydrate,
            edit: _edit,
            api: _api()
        };
    });

})();
