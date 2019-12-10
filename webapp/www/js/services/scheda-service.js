// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("SchedaService", function ($resource) {
        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {Scheda} scheda Oggetto da verificare
         */
        function _validate(scheda) {
            if (!angular.isObject(scheda)) {
                throw "Invalid object";
            }
        }

        /**
         * Applicata a un oggetto restituito dall'API, converte i dati forniti
         * in oggetti nativi. In particolare la data viene convertita in nativo.
         * L'oggetto viene modificato per riferimento ma è anche restituito
         * dal metodo per supportare uno stile fluent.
         * @param {Scheda} scheda
         * @returns {Scheda}
         */
        function _hydrate(scheda) {
            _validate(scheda);

            if (angular.isString(scheda.dataRilascio)) {
                scheda.dataRilascio = new Date(scheda.dataRilascio);
            }

            return scheda;
        }

        /**
         * Restituisce un nuovo oggetto.
         * @returns {Scheda}
         */
        function _new() {
            var scheda = {
                idScheda: null,
                idCliente: null,
                codice: null,
                importo: null,
                dataRilascio: null
            };

            return scheda;
        }

        function _api() {
            return $resource(_buildURL("clienti/:idCliente/schede/:idScheda"), {
                idCliente: "@idCliente",
                idScheda: "@idScheda"
            }, {
                update: {method: "PUT"}
            });
        }

        return {
            hydrate: _hydrate,
            new: _new
        };
    });

})();
