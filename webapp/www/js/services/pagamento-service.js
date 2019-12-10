// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("PagamentoService", function ($resource, $mdDialog) {
        /**
         * Solleva un'eccezione su l'oggetto non è valido
         * @param {Pagamento} pagamento Oggetto da verificare
         */
        function _validate(pagamento) {
            if (!angular.isObject(pagamento)) {
                throw "Invalid object";
            }
        }

        /**
         * Applicata a un oggetto restituito dall'API, converte i dati forniti
         * in oggetti nativi. In particolare la data viene convertita in nativo.
         * L'oggetto viene modificato per riferimento ma è anche restituito
         * dal metodo per supportare uno stile fluent.
         * @param {AssegnamentoPostazione} pagamento
         * @returns {AssegnamentoPostazione}
         */
        function _hydrate(pagamento) {
            _validate(pagamento);

            if (angular.isString(pagamento.data)) {
                pagamento.data = new Date(pagamento.data);
            }

            return pagamento;
        }

        function _api($resource) {
            return $resource(_buildURL("clienti/:idCliente/pagamenti/:idPagamento"), {
                idPostazione: "@idPostazione",
                idPagamento: "@idPagamento"
            }, {
                update: {method: "PUT"}
            });
        }

        function _edit($event, cliente, pagamento, success, cancel) {
            $mdDialog.show({
                targetEvent: $event,
                templateUrl: "views/forms/edit-pagamento.html",
                controller: "EditPaymentCtrl",
                locals: {
                    cliente: cliente,
                    pagamento: pagamento
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

        /**
         * Restituisce un nuovo oggetto che rappresenta il periodo in cui il
         * cliente ha noleggiato la postazione.
         * @returns {AssegnamentoPostazione}
         */
        function _new() {
            var pagamento = {
                idPagamento: null,
                data: null,
                importo: null
            };

            return pagamento;
        }

        return {
            hydrate: _hydrate,
            new: _new,
            edit: _edit,
            api: _api($resource)
        };
    });

})();
