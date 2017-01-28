/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class FirstRunCompleteController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public $http: ng.IHttpService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            let plugins = [
                {name: 'Admin area', value: 'admin'},
                {name: 'Amazon Web Services', value: 'aws'},
                {name: 'Bug catcher', value: 'bug'},
                {name: 'Command line tools', value: 'cli'},
                {name: 'Cron Manager', value: 'cron'},
                {name: 'Debugger', value: 'debug'},
                {name: 'Content Manager', value: 'cms'},
                {name: 'Mail manager', value: 'mail'},
                {name: 'Member\'s area', value: 'member'},
                {name: 'Support desk', value: 'support'},
                {name: 'Site Todos', value: 'todo'},
                {name: 'User manager', value: 'user'},
            ];

            this.$scope.data = {setup: {email: $scope.session.user.email, password: '', password2: ''}, plugins: plugins};
            //$timeout(this.finish, 100);
        }

        finish = () => {
            let data = this.$scope.data;

            if (data.setup.password === data.setup.password2) {
                data.loading = data.scroll = true;

                this.$http.post('', data.setup).then(
                    (result) => {
                        angular.element('#plugins').val(angular.toJson(data.setup.plugins));
                        angular.element('#installer').submit();
                        this.scroll();
                    },
                    (result) => {
                        data.loading = false;
                        this.$ui.toast('Error: ' + result.data);
                    }
                );
            } else {
                this.$ui.toast(this.gettext('Passwords do not match'));
            }
        };

        scroll = () => {
            var $contents = $('#frameProgress').contents();
            $contents.scrollTop($contents.height());

            if (this.$scope.data.loading && this.$scope.data.scroll) {
                this.$timeout(this.scroll, 100);
            }
        }
    }

    angular.module('FirstRunCompleteApp', ['MinuteFramework', 'gettext'])
        .controller('FirstRunCompleteController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', FirstRunCompleteController]);
}
