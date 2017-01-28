<?php

/** @var Binding $binding */
use App\Config\BootLoader;
use Auryn\Injector;
use Minute\Apache\ApacheConf;
use Minute\Apache\ApacheFile;
use Minute\App\App;
use Minute\Auth\CheckUserLogin;
use Minute\Auth\CreateNewUser;
use Minute\Auth\RetrievePassword;
use Minute\Auth\UpdateUserData;
use Minute\Bug\Catcher;
use Minute\Cache\QCache;
use Minute\Component\CmsComponent;
use Minute\Config\Config;
use Minute\Config\ConfigManager;
use Minute\Controller\Runnable;
use Minute\Database\Database;
use Minute\Docker\DockerFile;
use Minute\Event\AdminEvent;
use Minute\Event\ApacheEvent;
use Minute\Event\AppEvent;
use Minute\Event\AuthEvent;
use Minute\Event\Binding;
use Minute\Event\CmsEvent;
use Minute\Event\ControllerEvent;
use Minute\Event\Dispatcher;
use Minute\Event\DockerEvent;
use Minute\Event\MemberEvent;
use Minute\Event\ModelEvent;
use Minute\Event\PluginEvent;
use Minute\Event\ProviderEvent;
use Minute\Event\PurchaseEvent;
use Minute\Event\RawMailEvent;
use Minute\Event\RedirectEvent;
use Minute\Event\RequestEvent;
use Minute\Event\ResponseEvent;
use Minute\Event\RouterEvent;
use Minute\Event\SessionEvent;
use Minute\Event\TodoEvent;
use Minute\Event\UserAdminEvent;
use Minute\Event\UserForgotPasswordEvent;
use Minute\Event\UserLoginEvent;
use Minute\Event\UserProfileEvent;
use Minute\Event\UserSignupEvent;
use Minute\Event\UserUpdateDataEvent;
use Minute\Event\UserUploadEvent;
use Minute\EventManager\EventManager;
use Minute\Http\HttpRequestEx;
use Minute\Http\HttpResponseEx;
use Minute\Log\LoggerEx;
use Minute\Log\PaymentLogger;
use Minute\Mail\SesMailer;
use Minute\Menu\AdminMenu;
use Minute\Menu\AffiliateMenu;
use Minute\Menu\ArMenu;
use Minute\Menu\AuthMenu;
use Minute\Menu\AwsMenu;
use Minute\Menu\BugMenu;
use Minute\Menu\CmsMenu;
use Minute\Menu\CronMenu;
use Minute\Menu\DebugMenu;
use Minute\Menu\MailMenu;
use Minute\Menu\MemberMenu;
use Minute\Menu\MinifyMenu;
use Minute\Menu\PaymentMenu;
use Minute\Menu\ProductMenu;
use Minute\Menu\ProjectMenu;
use Minute\Menu\SupportMenu;
use Minute\Menu\TodoMenu;
use Minute\Menu\TranslateMenu;
use Minute\Menu\UserMenu;
use Minute\Panel\BugPanel;
use Minute\Panel\CachePanels;
use Minute\Panel\MailPanel;
use Minute\Panel\PaymentPanel;
use Minute\Panel\PluginPanel;
use Minute\Panel\ProjectPanel;
use Minute\Panel\SupportPanel;
use Minute\Panel\UserPanel;
use Minute\Payment\Processor;
use Minute\Payment\ProviderInfo;
use Minute\Plugin\PluginManager;
use Minute\Profile\UserProfile;
use Minute\Render\ModelPrinter;
use Minute\Render\Output;
use Minute\Render\Problem;
use Minute\Render\SessionPrinter;
use Minute\Router\CmsRouter;
use Minute\Routing\Router;
use Minute\Session\Session;
use Minute\Todo\ProductTodo;
use Minute\Upload\S3Uploader;

$binding->addMultiple([
    ['event' => ApacheEvent::IMPORT_HTTPD_CONF, 'handler' => [ApacheConf::class, 'getHttpdConf']],
]);