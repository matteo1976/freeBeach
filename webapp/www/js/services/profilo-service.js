// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("ProfiloService", function ($resource) {
        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {Profilo} profilo Oggetto da verificare
         */
        function _validate(profilo) {
            if (!angular.isObject(profilo)) {
                throw "Invalid object";
            }
        }

        /**
         * Restituisce un nuovo oggetto.
         * @returns {Profilo}
         */
        function _new() {
            var profilo = {
                idProfilo: null,
                descrizione: null,
                privilegi: null
            };

            return profilo;
        }

        function _api() {
            return $resource(_buildURL("profili/:idProfilo"), {
                idProfilo: "@idProfilo"
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
