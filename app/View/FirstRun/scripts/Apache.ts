/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class ApacheController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            let domain = $scope.session.site.domain;
            $scope.data = {'hosts': '127.0.0.1   ' + domain + ' www.' + domain, apache: {}, enabled: false};
        }

        go = () => {
            top.location.href = this.next();
        };

        next = () => {
            return this.$scope.data.enabled && (this.$scope.session.site.host + '/admin') || '/admin';
        };
    }

    angular.module('ApacheApp', ['MinuteFramework', 'gettext'])
        .controller('ApacheController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ApacheController]);
}
