// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("OperatoreService",
        function ($resource) {
            var _resource = $resource;

            /**
             * Estende le funzionalità dell'oggetto Operatore restituito dall'API.
             * Metodi già presenti nell'oggetto non vengono ridefiniti dal decorator.
             * L'oggetto viene modificato per riferimento ma è anche restituito
             * dal metodo per supportare uno stile fluent.
             * @param {Operatore} operatore L'oggetto Operatore da decorare. Se il paramerto
             * non è un oggetto valido viene sollevata un'eccezione "Invalid Object".
             * @returns {Operatore} L'oggetto modificato. Consente uno stile fluent
             * eseguendo un metodo direttamente sul operatore decorato.
             */
            function _decorate(operatore) {
                if (!angular.isObject(operatore)) {
                    debugger;
                    throw "Invalid object";
                }

                return operatore;
            }

            /**
             * Restituisce un nuovo oggetto Operatore.
             * @returns {Postazione}
             */
            function _new() {
                var operatore = {
                    idOperatore: null,
                    nome: null,
                    indirizzo: null,
                    email: null,
                    password: null,
                    abilitato: false,
                    profilo: null //Profilo { }
                };

                return this.decorate(operatore);
            }

            function _api(resource) {
                return resource(_buildURL("operatori/:idOperatore"), {
                    idOperatore: "@idOperatore"
                }, {
                    update: {method: "PUT"}
                });
            }

            return {
                decorate: _decorate,
                new: _new,
                api: _api(_resource)
            };
        });

})();
