<div class="container" ng-app="FirstRunCompleteApp" ng-controller="FirstRunCompleteController as mainCtrl" ng-cloak="">
    <div class="row">
        <div class="col-xs-12">
            <div>
                <h3 class="pull-left"><span translate="">Finalize installation</span></h3>
                <a class="pull-right" style="margin-top:20px; opacity: 0.33" href="//minutephp.com" target="_blank"><img src="/static/minute-logo.png" height="20" align="center"
                                                                                                                         title="MinutePHP Logo"></a>
                <div class="clearfix"></div>
                <hr style="margin-top: 0">
            </div>

            <p><span translate="">So far, so good! Your database has been successfully setup and now it's time to configure the admin access and install a few plugins!</span></p>

            <div class="well">
                <form class="form-horizontal" ng-submit="mainCtrl.finish()" ng-show="!data.loading">
                    <fieldset>
                        <h3 class="form-title text-bold">1. <span translate="">Admin access</span></h3>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="login"><span translate="">Admin email:</span></label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="login" placeholder="Enter Login email" ng-model="data.setup.email" ng-required="true">
                                <p class="help-block"><span translate="">(this is also your username)</span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="password"><span translate="">Admin password:</span></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" placeholder="Enter Admin password" ng-model="data.setup.password" ng-required="true" minlength="3">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="password"><span translate="">Confirm password:</span></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" placeholder="Confirm Admin password" ng-model="data.setup.password2" ng-required="true"
                                       ng-focus="data.warning = false" ng-blur="data.warning = true">

                                <ng-switch on="!!data.warning && !!data.setup.password2 && data.setup.password !== data.setup.password2">
                                    <p class="help-block" ng-switch-when="false"><span translate="">(type your password again to confirm)</span></p>
                                    <p class="help-block" ng-switch-when="true"><span class="text-danger" translate="">Passwords do not match</span></p>
                                </ng-switch>
                            </div>
                        </div>

                        <h3 class="form-title text-bold">2. <span translate="">Select plugins</span></h3>
                        <p class="help-block"><span translate="">Listed below are plugin that almost every site needs. Please don't change it unless you know what you're doing.</span></p>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="password"><span translate="">Install plugins:</span></label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline" ng-repeat="plugin in data.plugins" ng-init="data.setup.plugins[plugin.value] = true" ng-style="{marginLeft: 10}">
                                    <input type="checkbox" ng-model="data.setup.plugins[plugin.value]" readonly> {{plugin.name}}
                                </label>

                                <br><br>
                                <p class="help-block text-sm">
                                    <i class="fa fa-lightbulb-o"></i>
                                    <span translate="">97% users generally install all these plugins!<sup><abbr title="as per packagist stats">*</abbr></sup></span>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10" ng-show="!data.loading">
                                <button type="submit" class="btn btn-flat btn-primary"><span translate>Finish installation</span> <i class="fa fa-fw fa-angle-right"></i></button>
                            </div>
                            <div class="col-sm-offset-3 col-sm-10" ng-show="!!data.loading">
                                <p class="help-block"><i class="fa fa-spinner fa-spin"></i> <span translate="">Installation in progress. This may take a few minutes to complete.</span></p>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div ng-show="!!data.loading">
                    <h3><i class="fa fa-spinner fa-spin"></i> <span translate="">Installing plugins</span></h3>
                    <form method="post" action="/first-run/installer" id="installer" target="progress">
                        <input type="hidden" name="plugins" id="plugins" value="">
                    </form>
                    <iframe frameborder="no" width="100%" height="350" id="frameProgress" name="progress" src="about:blank"></iframe>

                    <label><input type="checkbox" ng-model="data.scroll"> Disable auto-scroll</label>
                </div>
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