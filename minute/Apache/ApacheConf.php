<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/22/2016
 * Time: 10:26 PM
 */
namespace Minute\Apache {

    use App\Config\BootLoader;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use StringTemplate\Engine;

    class ApacheConf {
        /**
         * @var Engine
         */
        private $engine;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var BootLoader
         */
        private $bootLoader;

        /**
         * ApacheConf constructor.
         *
         * @param Engine $engine
         * @param Config $config
         * @param BootLoader $bootLoader
         */
        public function __construct(Engine $engine, Config $config, BootLoader $bootLoader) {
            $this->engine     = $engine;
            $this->config     = $config;
            $this->bootLoader = $bootLoader;
        }

        public function getHttpdConf(ImportEvent $event) {
            $httpd = file_get_contents(__DIR__ . '/data/apache.conf.txt');
            $conf  = $this->engine->render($httpd, array_merge($this->config->getPublicVars(), ['path' => realpath($this->bootLoader->getBaseDir() . '/public')]));

            $event->setContent(['conf' => $conf]);
        }
    }
}