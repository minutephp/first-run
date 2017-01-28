<div class="container" ng-app="FirstRunApp" ng-controller="FirstRunController as mainCtrl" ng-cloak="">
    <div class="row">
        <div class="col-xs-12">
            <div>
                <h3 class="pull-left"><span translate="">Setup wizard</span></h3>
                <a class="pull-right" style="margin-top:20px; opacity: 0.33" href="//minutephp.com" target="_blank"><img src="/static/minute-logo.png" height="20" align="center" title="MinutePHP Logo"></a>
                <div class="clearfix"></div>
                <hr style="margin-top: 0">
            </div>

            <p><span translate="">This wizard will help you create a basic configuration file and setup your database.</span></p>

            <div class="well">
                <form class="form-horizontal" ng-submit="mainCtrl.startSetup()">
                    <fieldset>
                        <h3 class="form-title text-bold">1. <span translate="">Website information</span></h3>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="domain"><span translate="">Domain name:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="domain" placeholder="example.com, mysite.org, etc" ng-model="data.setup.site.domain"
                                       ng-required="true" ng-blur="mainCtrl.autofill()" auto-focus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="site_name"><span translate="">Website name:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="site_name" placeholder="Enter Website name" ng-model="data.setup.site.site_name" ng-required="true">
                            </div>
                        </div>

                        <h3 class="form-title text-bold">2. <span translate="">Mysql configuration</span></h3>

                        <p><span translate="">Please create a MySQL database on your server and enter the connection details below:</span></p>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="db_name"><span translate="">Database name:</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="db_name" placeholder="Enter Database name" ng-model="data.setup.db.database" ng-required="true">
                            </div>
                            <div class="col-sm-3 hide-xs">
                                <sup ng-show="data.setup.db.database && data.setup.db.username && data.setup.db.password" class="pull-right">
                                    <a href="" class="btn btn-xs btn-default" tabindex="-1" title="Copy SQL statements" ng-click="mainCtrl.showHelper()"><i class="fa fa-magic"></i></a>
                                </sup>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="dbuser">
                                <b><span translate="">Connection details:</span></b>
                            </label>

                            <div class="col-sm-3">
                                <input class="form-control" ng-model="data.setup.db.username" type="text" placeholder="Database username" ng-required="true" />
                                <small><span translate="">(your mysql username)</span></small>
                            </div>

                            <div class="col-sm-3">
                                <input class="form-control" ng-model="data.setup.db.password" type="password" placeholder="Database password" ng-required="true" />
                                <small><span translate="">(your mysql password)</span></small>
                            </div>

                            <div class="col-sm-3">
                                <input class="form-control" ng-model="data.setup.db.host" type="text" placeholder="Database host" ng-required="true" />
                                <small><span translate="">(server hostname)</span></small>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10" ng-show="!data.loading">
                                <button type="submit" class="btn btn-flat btn-primary"><span translate>Begin installation</span> <i class="fa fa-fw fa-angle-right"></i></button>
                            </div>
                            <div class="col-sm-offset-3 col-sm-10" ng-show="!!data.loading">
                                <p class="help-block"><i class="fa fa-spinner fa-spin"></i> <span translate="">Installation in progress. This may take a few minutes to complete.</span></p>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <script type="text/ng-template" id="/sql-popup.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Database setup helper</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <div class="box-body">
                <form>
                    <p class="help-block"><span translate="">You can paste the following SQL statements in your MySQL server to create a new database:</span></p>
                    <div class="form-group">
                        <div>
                            <textarea class="form-control" rows="5" placeholder="Enter Sql statements" ng-model="sqls" readonly auto-focus onfocus="this.select()" ng-required="false"></textarea>

                            <p class="help-block"><span translate="">Copy-paste these SQL statements in adminer or mysql console to setup your new database</span></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </script>

</div>