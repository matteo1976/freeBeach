// vim: set ts=4 sw=4 expandtab:

/**
 * Generates a full URL for the REST endpoint
 * @param {String} url    The REST endpoint URL relative to site root
 * @returns {String}      The REST endpoint full URL
 */
function _buildURL(url) {
    var host = "http://api.sb.local/";
    //var host = "http://192.168.2.2:8080/";

    if (url.substring(url.length - 1) !== "/")
        url += "/";

    return host + url;
}

(function () {
    "use strict";

    // Creates an empty module for controllers
    var controllers = angular.module("controllers", []);

    // Application module
    var app = angular.module("beachSeat", [
        "ngMaterial",
        "ngMessages",
        "ngRoute",
        "ngResource",
        "controllers"
    ]);

    app.config(["$compileProvider", function ($compileProvider) {
            $compileProvider.debugInfoEnabled(false);
        }]);

    app.config(function ($mdDateLocaleProvider) {

        // Months
        $mdDateLocaleProvider.months = [
            "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
            "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
        ];

        $mdDateLocaleProvider.shortMonths = [
            "Gen", "Feb", "Mar", "Apr", "Mag", "Giu",
            "Lug", "Ago", "Set", "Ott", "Nov", "Dic"
        ];

        // Week days
        $mdDateLocaleProvider.days = [
            "Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì",
            "Venerdì", "Sabato", "Domnica"
        ];

        $mdDateLocaleProvider.shortDays = [
            "Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"
        ];

        // Can change week display to start on Monday.
        $mdDateLocaleProvider.firstDayOfWeek = 1;

        // Optional.
        //$mdDateLocaleProvider.dates = [1, 2, 3, 4, 5, 6, ...];

        // Example uses moment.js to parse and format dates.
        $mdDateLocaleProvider.parseDate = function (dateString) {
            if (angular.isString(dateString)) {
                var s = dateString.split("/");

                if (s.length !== 3) {
                    return new Date(NaN);
                }

                var d = new Date();

                d.setYear(s[2]);
                d.setMonth(s[1] - 1);
                d.setDate(s[0]);

                return d;
            } else {
                return new Date(NaN);
            }

            var m = moment(dateString, "L", true);
            return m.isValid() ? m.toDate() : new Date(NaN);
        };

        $mdDateLocaleProvider.formatDate = function (date) {
            if (date === null) {
                return "";
            } else {
                return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
            }
        };

        $mdDateLocaleProvider.monthHeaderFormatter = function (date) {
            return $mdDateLocaleProvider.shortMonths[date.getMonth()] + " " + date.getFullYear();
        };

        // In addition to date display, date components also need localized messages
        // for aria-labels for screen-reader users.

        $mdDateLocaleProvider.weekNumberFormatter = function (weekNumber) {
            return "Settimana " + weekNumber;
        };

        $mdDateLocaleProvider.msgCalendar = "Calendario";
        $mdDateLocaleProvider.msgOpenCalendar = "Apri il calendario";

        // You can also set when your calendar begins and ends.
        //$mdDateLocaleProvider.firstRenderableDate = new Date(1776, 6, 4);
        //$mdDateLocaleProvider.lastRenderableDate = new Date(2012, 11, 21);
    });

    // <editor-fold defaultstate="collapsed" desc="Routes">

    app.config([
        "$routeProvider",
        function ($routeProvider) {
            $routeProvider.
            /*when("/edit-expense/:expenseId", {
             templateUrl: "partials/edit-expense.html",
             controller: "EditExpenseController"
             }).*/
            when("/map", {
                templateUrl: "views/map/map.html",
                controller: "MapCtrl"
            }).
            when("/omni-search", {
                templateUrl: "views/omni-search/main.html",
                controller: "OmniSearchCtrl"
            }).
//                when("/about", {
//                    templateUrl: "partials/about.html"
//                }).
//                when("/login", {
//                    templateUrl: "partials/login.html"
//                }).
            otherwise({
                redirectTo: "/map"
            });
        }
    ]);

    // </editor-fold>

    // <editor-fold defaultstate="uncollapsed" desc="Resources">

    /*
     * By default, trailing slashes will be stripped from the calculated URLs, which
     * can pose problems with server backends that do not expect that behavior.
     * This can be disabled by configuring the $resourceProvider like this:
     */
    app.config([
        "$resourceProvider",
        function ($resourceProvider) {
            $resourceProvider.defaults.stripTrailingSlashes = true;
        }
    ]);

    app.factory("DisponibilitaPostazione", [
        "$resource",
        function ($resource) {
            return $resource(_buildURL(
            "postazioni/:idPostazione/assegnamenti/:idAssegnamento/disponibilita/:idDisponibilita"),
            {
                idPostazione: "@idPostazione",
                idAssegnamento: "@idAssegnamento",
                idDisponibilita: "@idDisponibilita"
            },
            {
                update: {method: "PUT"}
            });
        }
    ]);

    app.factory("SubaffittiPostazione", [
        "$resource",
        function ($resource) {
            return $resource(_buildURL(
            "postazioni/:idPostazione/assegnamenti/:idAssegnamento/disponibilita/:idDisponibilita/subaffitti/:idSubaffitto"),
            {
                idPostazione: "@idPostazione",
                idAssegnamento: "@idAssegnamento",
                idDisponibilita: "@idDisponibilita",
                idSubaffitto: "@idSubaffitto"
            },
            {
                update: {method: "PUT"}
            });
        }
    ]);

    // </editor-fold>

})();
