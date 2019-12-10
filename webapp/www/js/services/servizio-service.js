// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("ServizioService", function ($resource, $mdDialog) {

        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {CostoServizio} costoServizio Oggetto da verificare
         */
        function _validate(servizio) {
            if (!angular.isObject(servizio)) {
                throw "Invalid object";
            }
        }

        /**
         * Restituisce un nuovo oggetto.
         * @returns {CostoServizio}
         */
        function _new() {
            var servizio = {
                idServizio: null,
                idAssegnamento: null,
                dataInizio: null,
                dataFine: null,
                qta: null,
                costoFinale: null,
                note: null,
                idTipoServizio: null
            };

            return servizio;
        }

        function _edit($event, servizio, assegnamento, postazione, success, cancel)
        {
            $mdDialog.show({
                targetEvent: $event,
                templateUrl: "views/forms/edit-servizio.html",
                controller: "EditServiceCtrl",
                locals: {
                    servizio: servizio,
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

        function _api() {
            return $resource(_buildURL("postazioni/:idPostazione/assegnamenti/:idAssegnamento/servizi/:idServizio"), {
                idPostazione: "@idPostazione",
                idAssegnamento: "@idAssegnamento",
                idServizio: "@idServizio"
            }, {
                update: {method: "PUT"}
            });
        }

        return {
            new: _new,
            edit: _edit,
            api: _api()
        };
    });

})();
