/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var ApacheController = (function () {
        function ApacheController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.go = function () {
                top.location.href = _this.next();
            };
            this.next = function () {
                return _this.$scope.data.enabled && (_this.$scope.session.site.host + '/admin') || '/admin';
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            var domain = $scope.session.site.domain;
            $scope.data = { 'hosts': '127.0.0.1   ' + domain + ' www.' + domain, apache: {}, enabled: false };
        }
        return ApacheController;
    }());
    Admin.ApacheController = ApacheController;
    angular.module('ApacheApp', ['MinuteFramework', 'gettext'])
        .controller('ApacheController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ApacheController]);
})(Admin || (Admin = {}));
