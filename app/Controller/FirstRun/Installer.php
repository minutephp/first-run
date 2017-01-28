<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\FirstRun {

    use App\Config\BootLoader;
    use Minute\Http\HttpRequestEx;
    use Minute\Plugin\PluginInstaller;
    use Minute\Shell\Shell;

    class Installer {
        /**
         * @var BootLoader
         */
        private $bootLoader;
        /**
         * @var Shell
         */
        private $shell;
        /**
         * @var PluginInstaller
         */
        private $installer;

        /**
         * PluginInstaller constructor.
         *
         * @param BootLoader $bootLoader
         * @param Shell $shell
         * @param PluginInstaller $installer
         */
        public function __construct(BootLoader $bootLoader, Shell $shell, PluginInstaller $installer) {
            set_time_limit(0);
            $this->bootLoader = $bootLoader;
            $this->shell      = $shell;
            $this->installer  = $installer;
        }

        public function index(HttpRequestEx $request) {
            $params = $request->getParameters();

            if (!empty($params['plugins'])) {
                $plugins = json_decode($params['plugins'], true);

                foreach ($plugins as $plugin => $tick) {
                    if ($tick) $enabled[] = $plugin;
                }

                if (!empty($enabled)) {
                    echo "<pre>Starting composer..\n";
                    //chdir($this->bootLoader->getBaseDir());
                    //$output = $this->shell->run('composer -vv require %s', array_map(function ($f) { return "minutephp/$f:dev-master"; }, $enabled));
                    $plugins = array_map(function ($f) { return "minutephp/$f"; }, $enabled);
                    $success = $this->installer->install($plugins);

                    if ($success) { //--prefer-source
                        echo '<h3>All done!</h3>';
                        echo '<script>top.location.href = "/first-run/apache";</script>';
                    } else {
                        echo "<h3>Something didn't go as expected.</h3>";
                    }
                }
            }
        }
    }
}
