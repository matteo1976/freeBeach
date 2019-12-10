// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("AbbonamentoService", function ($resource) {
        var _resource = $resource;

        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {Abbonamento} abbonamento Oggetto da verificare
         */
        function _validate(abbonamento) {
            if (!angular.isObject(abbonamento)) {
                throw "Invalid object";
            }
        }

        /**
         * Restituisce un nuovo oggetto.
         * @returns {Abbonamento}
         */
        function _new() {
            var abbonamento = {
                idAbbonamento: null,
                codice: null,
                costo: null
            };

            return abbonamento;
        }

        function _api() {
            return _resource(_buildURL("abbonamenti/:idAbbonamento"), {
                idAbbonamento: "@idAbbonamento"
            }, {
                update: {method: "PUT"}
            });
        }

        return {
            new: _new,
            api: _api()
        };
    });

})();
