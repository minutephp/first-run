<div class="container" ng-app="ApacheApp" ng-controller="ApacheController as mainCtrl" ng-cloak="">
    <div class="row">
        <div class="col-xs-12">
            <div>
                <h3 class="pull-left"><span translate="">All Systems Are Go!</span></h3>
                <a class="pull-right" style="margin-top:20px; opacity: 0.33" href="//minutephp.com" target="_blank">
                    <img src="/static/minute-logo.png" height="20" align="center" title="MinutePHP Logo">
                </a>
                <div class="clearfix"></div>
                <hr style="margin-top: 0">
            </div>

            <p>
                <span translate="">All you need to do now is to configure your Apache server (and hosts file) for local development.</span>
                <span translate="">With MinutePHP you can automatically deploy your site to </span>
                 <a href="//google.com/search?q=Amazon+Elastic+Beanstalk" target="_blank">Amazon's Elastic Beanstalk</a>
                <span translate="">(or any hosting provider that supports Docker) in 1 click!</span>
            </p>

            <div class="well">
                <minute-event name="import.httpd.conf" as="data.apache"></minute-event>

                <form ng-submit="mainCtrl.go()">
                    <fieldset>
                        <h3 class="form-title text-bold"><span translate="">1. Setup apache</span></h3>
                        <p class="help-block"><span translate="">Apache server (with php 7+) is required on your local machine for development. Please add the following to your
                                Apache's httpd.conf file, and then restart your Apache server.</span></p>

                        <div class="form-group">
                            <label class="control-label pull-left" for="conf">
                                <span translate="">Paste this in your </span> <code>httpd.conf</code>:
                            </label>
                            <a class="pull-right" href="//google.com/search?q=configure+apache+virtual+host+wamp" target="_blank">
                                <i class="fa fa-question-circle"></i> <span translate="">Learn more</span>
                            </a>
                            <div class="clearfix"></div>

                            <div>
                                <textarea class="form-control" rows="5" onfocus="this.select()" placeholder="Apache configuration" readonly>{{data.apache.conf}}</textarea>
                            </div>
                        </div>

                        <h3 class="form-title text-bold"><span translate="">2. Configure hosts file</span></h3>
                        <p class="help-block"><span translate="">To handle all requests sent to {{session.site.domain}} during development, please paste the following in your hosts file.</span></p>


                        <div class="form-group">
                            <label class="control-label" for="conf">
                                <span translate="">Paste this in your </span> <code>hosts</code> <span translate="">file</span>:
                            </label>
                            <div>
                                <input type="text" class="form-control" onfocus="this.select()" placeholder="hosts file" readonly value="{{data.hosts}}">
                                <p class="help-block"><span translate="">Location of host file: /etc/hosts on linux, %windir%/system32/drivers/etc/hosts on windows</span>
                                    - <a href="//google.com/search?q=Location+of+host+file" target="_blank"><span translate="">learn more</span></a></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="conf">
                                <span translate="">All set?</span>
                            </label>
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="data.enabled" ng-value="true"> <span translate="">I have updated my Apache server* and hosts file</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="data.enabled" ng-value="false"> <span translate="">I will configure these later (not recommended)</span>
                                </label>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-flat">
                                <span translate="">Go to </span> {{mainCtrl.next()}} <i class="fa fa-fw fa-angle-right"></i>
                            </button>
                        </div>

                        <div class="form-group" ng-show="data.enabled">
                            <p class="help-block text-sm">
                                <small translate=""><sup>*</sup> Make sure to restart your local Apache server after making changes!</small>
                            </p>
                        </div>


                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>