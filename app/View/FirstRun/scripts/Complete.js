/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var FirstRunCompleteController = (function () {
        function FirstRunCompleteController($scope, $minute, $ui, $timeout, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.finish = function () {
                var data = _this.$scope.data;
                if (data.setup.password === data.setup.password2) {
                    data.loading = data.scroll = true;
                    _this.$http.post('', data.setup).then(function (result) {
                        angular.element('#plugins').val(angular.toJson(data.setup.plugins));
                        angular.element('#installer').submit();
                        _this.scroll();
                    }, function (result) {
                        data.loading = false;
                        _this.$ui.toast('Error: ' + result.data);
                    });
                }
                else {
                    _this.$ui.toast(_this.gettext('Passwords do not match'));
                }
            };
            this.scroll = function () {
                var $contents = $('#frameProgress').contents();
                $contents.scrollTop($contents.height());
                if (_this.$scope.data.loading && _this.$scope.data.scroll) {
                    _this.$timeout(_this.scroll, 100);
                }
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            var plugins = [
                { name: 'Admin area', value: 'admin' },
                { name: 'Amazon Web Services', value: 'aws' },
                { name: 'Bug catcher', value: 'bug' },
                { name: 'Command line tools', value: 'cli' },
                { name: 'Cron Manager', value: 'cron' },
                { name: 'Debugger', value: 'debug' },
                { name: 'Content Manager', value: 'cms' },
                { name: 'Mail manager', value: 'mail' },
                { name: 'Member\'s area', value: 'member' },
                { name: 'Support desk', value: 'support' },
                { name: 'Site Todos', value: 'todo' },
                { name: 'User manager', value: 'user' },
            ];
            this.$scope.data = { setup: { email: $scope.session.user.email, password: '', password2: '' }, plugins: plugins };
            //$timeout(this.finish, 100);
        }
        return FirstRunCompleteController;
    }());
    Admin.FirstRunCompleteController = FirstRunCompleteController;
    angular.module('FirstRunCompleteApp', ['MinuteFramework', 'gettext'])
        .controller('FirstRunCompleteController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', FirstRunCompleteController]);
})(Admin || (Admin = {}));
