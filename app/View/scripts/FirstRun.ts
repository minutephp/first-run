/// <reference path="../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class FirstRunController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public $http: ng.IHttpService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {setup: {site: {}, db: {host: 'localhost'}}};
            //$scope.data = {setup: {site: {domain: 'bulla.com', site_name: "bullaram"}, db: {database: 'fff', username: 'root', password: 'san', host: 'localhost'}}};
        }

        startSetup = () => {
            let data = this.$scope.data;
            data.loading = true;

            this.$http.post('', data.setup).then(
                (result) => {
                    top.location.href = '/first-run/complete';
                },
                (result) => {
                    data.loading = false;
                    this.$ui.toast('ERROR: ' + result.data, 'error');
                }
            );
        };

        autofill = () => {
            let setup = this.$scope.data.setup;
            if (setup.site.domain) {
                setup.site.domain = setup.site.domain.replace(/^www\./i, '');
                let name = setup.site.domain.replace(/\..*/, '');

                if (!setup.site.site_name) setup.site.site_name = name;
                if (!setup.db.database) setup.db.database = name;
                if (!setup.db.username) setup.db.username = name;
            }
        };

        showHelper = () => {
            let db = this.$scope.data.setup.db;
            let sqls = "CREATE DATABASE " + db.database + ";\nGRANT ALL PRIVILEGES ON " + db.database + ".* TO " + db.username + "@'" + (db.host || '%') + "' IDENTIFIED BY '" + db.password + "';\nFLUSH PRIVILEGES;\n"
            this.$ui.popupUrl('/sql-popup.html', false, null, {sqls: sqls});
        };
    }

    angular.module('FirstRunApp', ['MinuteFramework', 'gettext'])
        .controller('FirstRunController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', FirstRunController]);
}