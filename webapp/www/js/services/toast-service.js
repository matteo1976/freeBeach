// vim: set ts=4 sw=4 expandtab:
(function () {
    "use strict";

    var app = angular.module("beachSeat");

    app.factory("ToastService", function ($mdToast) {

        // Toast code from material.angularjs.org
        var last = {
            bottom: true,
            top: false,
            left: false,
            right: false
        };

        //$scope.toastPosition = angular.extend({}, last);
        var toastPosition = angular.extend({}, last);

        function sanitizePosition() {
            var current = toastPosition;

            if (current.bottom && last.top)
                current.top = false;
            if (current.top && last.bottom)
                current.bottom = false;
            if (current.right && last.left)
                current.left = false;
            if (current.left && last.right)
                current.right = false;

            last = angular.extend({}, current);
        }

        //$scope.getToastPosition = function () {
        function getToastPosition() {
            sanitizePosition();

            return Object.keys(toastPosition)
            .filter(function (pos) {
                return toastPosition[pos];
            })
            .join(' ');
        };

        //$scope.showSimpleToast = function (message) {
        function showSimpleToast(message) {
            var pinTo = getToastPosition();

            $mdToast.show(
            $mdToast.simple()
            .textContent(message)
            .position(pinTo)
            .hideDelay(3000)
            );
        };

        return {
            showSimpleToast: showSimpleToast
        };
    });

})();
