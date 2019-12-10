// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("PostazioneService",
        function ($resource, $mdDialog, AssegnamentoService) {

            /**
             * Estende le funzionalità dell'oggetto restituito dall'API.
             * L'oggetto viene modificato per riferimento ma è anche restituito
             * dal metodo per supportare uno stile fluent.
             * Solleva un'eccezione su l'oggetto non è valido.
             * @param {Postazione} postazione
             * @returns {Postazione}
             */
            function _decorate(postazione) {
                if (!angular.isObject(postazione)) {
                    debugger;
                    throw "Invalid object";
                }

                // Idrata gli assegnamenti
                if (angular.isArray(postazione.assegnamenti)) {
                    for (var i = 0; i < postazione.assegnamenti.length; i++) {
                        AssegnamentoService.hydrate(postazione.assegnamenti[i]);
                    }
                }

                // Aggiunge metodo getAssegnamento
                if (!postazione.hasOwnProperty("getAssegnamento")) {
                    postazione.getAssegnamento = function (date) {
                        if (!angular.isObject(postazione.assegnamenti))
                            return null;

                        for (var i = 0; i < postazione.assegnamenti.length; i++) {
                            var a = postazione.assegnamenti[i];
                            if (a.dataInizio <= date && a.dataFine >= date) {
                                return a;
                            }
                        }

                        return null;
                    };
                }

                // Aggiunge metodo getPrimoAssegnamento
                if (!postazione.hasOwnProperty("getPrimoAssegnamento")) {
                    postazione.getPrimoAssegnamento = function () {
                        if (!angular.isObject(postazione.assegnamenti))
                            return null;

                        var date = new Date();

                        for (var i = 0; i < postazione.assegnamenti.length; i++) {
                            var a = postazione.assegnamenti[i];
                            if (a.dataInizio <= date && a.dataFine >= date) {
                                return a;
                            } else if (a.dataInizio > date) {
                                return a;
                            }
                        }

                        return null;
                    };
                }

                // Aggiunge metodo isOccupata
                if (!postazione.hasOwnProperty("isOccupata")) {
                    postazione.isOccupata = function (date) {
                        if (angular.isUndefined(date))
                            date = new Date();

                        return postazione.getAssegnamento(date) !== null;
                    };
                }

                // Aggiunge metodo hasAssegnamenti
                if (!postazione.hasOwnProperty("hasAssegnamenti")) {
                    postazione.hasAssegnamenti = function () {
                        return angular.isObject(postazione.assegnamenti) && postazione.assegnamenti.length > 0;
                    };
                }

                // Aggiunge metodo getDisponibilita
                if (!postazione.hasOwnProperty("getDisponibilita")) {
                    postazione.getDisponibilita = function (from, to) {
                        if (!angular.isDate(from) || !angular.isDate(to))
                            return;

                        var ass = postazione.getAssegnamento(from);

                        if (ass === null)
                            return "full";
                        else if (ass.dataInizio <= from && ass.dataFine >= to)
                            return "none";
                        else if (ass.dataInizio <= from && ass.dataFine >= from)
                            return "partial";
                        else
                            return "full";
                    };
                }

                // Aggiunge metodo getCode
                if (!postazione.hasOwnProperty("getCode")) {
                    postazione.getCode = function () {
                        var f = postazione.fila === null ? "" : postazione.fila;
                        var c = postazione.colonna === null ? "" : postazione.colonna;
                        return f + c;
                    };
                }

                // View model
                if (!postazione.hasOwnProperty("viewModel")) {
                    postazione._viewModelCache = null;

                    postazione.viewModel = function (mapDate) {
                        // Se il viewModel in cache è aggiornato restituisce quello
                        if (angular.isObject(postazione._viewModelCache)) {
                            if (postazione._viewModelCache.mapDate === mapDate)
                                return postazione._viewModelCache;
                        }

                        // Creo un nuovo view model
                        var vm = {
                            mapDate: mapDate,
                            isOccupata: false,
                            nomeCliente: null,
                            inizioAssegnamento: null,
                            fineAssegnamento: null
                        };

                        // Cerca l'assegnamento corrente o il prossimo
                        // e aggiorna il view model
                        var assegnamento = postazione.getAssegnamento(mapDate);
                        if (assegnamento !== null) {
                            vm.isOccupata = true;
                        } else {
                            assegnamento = postazione.getPrimoAssegnamento();
                        }
                        if (assegnamento !== null) {
                            if (assegnamento.cliente === undefined)
                                debugger;

                            /*
                             * TODO: Il fatto che clienti e accounts siano al plurale
                             * lascia sospettare qualche relazione sbagliata sul database.
                             * Indagare e correggere.
                             */
                            vm.nomeCliente = assegnamento.cliente.nome;
                            vm.inizioAssegnamento = assegnamento.dataInizio;
                            vm.fineAssegnamento = assegnamento.dataFine;
                        }

                        // Aggiorna la cache
                        postazione._viewModelCache = vm;
                    };
                }

                // Conversione in formato swagger
                if (!postazione.hasOwnProperty("toSwagger")) {
                    postazione.toSwagger = function () {
                        return {
                            idPostazione: postazione.idPostazione,
                            settore: postazione.settore,
                            fila: postazione.fila,
                            colonna: postazione.colonna,
                            x: postazione.x,
                            y: postazione.y,
                            note: postazione.note
                        };
                    }
                }

                return postazione;
            }

            /**
             * Restituisce un nuovo oggetto che rappresenta la postazione.
             * @returns {Postazione}
             */
            function _new() {
                var postazione = {
                    idPostazione: null,
                    settore: "",
                    fila: "",
                    colonna: "",
                    x: null,
                    y: null,
                    note: null,
                    assegnamenti: [],
                    disponibilita: []
                };

                return this.decorate(postazione);
            }

            function _apiSpots($resource) {
                return $resource(_buildURL("postazioni/:idPostazione"), {
                    idPostazione: "@idPostazione"
                }, {
                    update: {method: "PUT"}
                });
            }

            function _apiSpotAssignments(resource) {
                return resource(_buildURL("postazioni/:idPostazione/assegnamenti/:idAssegnamento"), {
                    idPostazione: "@idPostazioni",
                    idAssegnamento: "@idAssegnamento"
                }, {
                    update: {method: "PUT"}
                });
            }

            /**
             * Split a string into a row, column pair
             * @param {string} text
             * @returns {object} An object with row and column properties
             */
            function _parse(text) {
                function isChar(str, pos) {
                    var cc = str.charCodeAt(pos);
                    return cc >= 65 && cc <= 90;
                }

                function isNumber(str, pos) {
                    var cc = str.charCodeAt(pos);
                    return cc >= 48 && cc <= 57;
                }

                if (text === null || text === undefined)
                    return null;

                text = text.trim().toUpperCase();

                var i = 0;
                while (i < text.length && isChar(text, i))
                    i++;
                var row = text.substring(0, i);

                var j = i;
                while (j < text.length && isNumber(text, j))
                    j++;
                var col = text.substring(i, j);

                return {
                    row: row,
                    col: col
                };
            }

            function _edit($event, postazione, dataInizio, success, cancel) {
                $mdDialog.show({
                    targetEvent: $event,
                    templateUrl: "views/forms/edit-postazione.html",
                    controller: "EditSpotCtrl",
                    locals: {
                        postazione: postazione,
                        dataInizio: dataInizio
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
                new : _new,
                edit: _edit,
                parse: _parse,
                api: {
                    spot: _apiSpots($resource),
                    assignment: _apiSpotAssignments($resource)
                }
            };
        });

})();
