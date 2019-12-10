// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("TipoServizioService", function ($resource, $mdDialog) {

        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {CostoServizio} costoServizio Oggetto da verificare
         */
        function _validate(tipoServizio) {
            if (!angular.isObject(tipoServizio)) {
                throw "Invalid object";
            }
        }

        /**
         * Restituisce un nuovo oggetto.
         * @returns {CostoServizio}
         */
        function _new() {
            var tipoServizio = {
                idTipoServizio: null,
                descrizione: null,
                costo: []
            };

            return _decorate(tipoServizio);
        }

        function _api() {
            return $resource(_buildURL("tipiServizio/:idTipoServizio"), {
                idTipoServizio: "@idTipoServizio"
            }, {
                update: {method: "PUT"}
            });
        }

        function _decorate(tipoServizio) {
            _validate(tipoServizio);

            if (!tipoServizio.hasOwnProperty("hasCosto")) {
                tipoServizio.hasCosto = function () {
                    return angular.isArray(tipoServizio.costo) && tipoServizio.costo.length > 0;
                };
            }

            if (!tipoServizio.hasOwnProperty("addCosto")) {
                tipoServizio.addCosto = function (costoServizio) {
                    if (!angular.isArray(tipoServizio.costo)) {
                        tipoServizio.costo = [];
                    }

                    tipoServizio.costo.push(costoServizio);
                };
            }

            return tipoServizio;
        }

        function _edit($event, tipoServizio, success, error) {
            $mdDialog.show({
                targetEvent: $event,
                templateUrl: "views/forms/edit-tipo-servizio.html",
                controller: "EditServiceTypeCtrl",
                locals: {
                    tipoServizio: tipoServizio,
                    success: success,
                    error: error
                },
                parent: angular.element(document.body),
                multiple: true,
                escapeToClose: true
            });
        }

        return {
            new: _new,
            decorate: _decorate,
            edit: _edit,
            api: _api()
        };
    });

})();
