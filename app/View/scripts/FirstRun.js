/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var FirstRunController = (function () {
        function FirstRunController($scope, $minute, $ui, $timeout, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.startSetup = function () {
                var data = _this.$scope.data;
                data.loading = true;
                _this.$http.post('', data.setup).then(function (result) {
                    top.location.href = '/first-run/complete';
                }, function (result) {
                    data.loading = false;
                    _this.$ui.toast('ERROR: ' + result.data, 'error');
                });
            };
            this.autofill = function () {
                var setup = _this.$scope.data.setup;
                if (setup.site.domain) {
                    setup.site.domain = setup.site.domain.replace(/^www\./i, '');
                    var name_1 = setup.site.domain.replace(/\..*/, '');
                    if (!setup.site.site_name)
                        setup.site.site_name = name_1;
                    if (!setup.db.database)
                        setup.db.database = name_1;
                    if (!setup.db.username)
                        setup.db.username = name_1;
                }
            };
            this.showHelper = function () {
                var db = _this.$scope.data.setup.db;
                var sqls = "CREATE DATABASE " + db.database + ";\nGRANT ALL PRIVILEGES ON " + db.database + ".* TO " + db.username + "@'" + (db.host || '%') + "' IDENTIFIED BY '" + db.password + "';\nFLUSH PRIVILEGES;\n";
                _this.$ui.popupUrl('/sql-popup.html', false, null, { sqls: sqls });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { setup: { site: {}, db: { host: 'localhost' } } };
            //$scope.data = {setup: {site: {domain: 'bulla.com', site_name: "bullaram"}, db: {database: 'fff', username: 'root', password: 'san', host: 'localhost'}}};
        }
        return FirstRunController;
    }());
    Admin.FirstRunController = FirstRunController;
    angular.module('FirstRunApp', ['MinuteFramework', 'gettext'])
        .controller('FirstRunController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', FirstRunController]);
})(Admin || (Admin = {}));
