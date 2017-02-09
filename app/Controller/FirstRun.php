<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller {

    use App\Config\BootLoader;
    use Illuminate\Support\Str;
    use Minute\Database\Database;
    use Minute\Error\FirstRunError;
    use Minute\Http\HttpRequestEx;
    use Minute\Lang\Lang;
    use Minute\Plugin\PluginInstaller;
    use Minute\Session\Session;
    use Minute\Password\PasswordHash;
    use Minute\Utils\Sniffer;
    use Minute\View\View;

    class FirstRun {
        /**
         * @var Database
         */
        private $database;
        /**
         * @var Lang
         */
        private $lang;
        /**
         * @var BootLoader
         */
        private $bootLoader;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var PluginInstaller
         */
        private $installer;
        /**
         * @var Sniffer
         */
        private $sniffer;
        /**
         * @var PasswordHash
         */
        private $passwordHash;

        /**
         * FirstRun constructor.
         *
         * @param Database $database
         * @param Lang $lang
         * @param BootLoader $bootLoader
         * @param Session $session
         *
         * @param PluginInstaller $installer
         *
         * @param Sniffer $sniffer
         *
         * @param PasswordHash $passwordHash
         *
         * @throws FirstRunError
         */
        public function __construct(Database $database, Lang $lang, BootLoader $bootLoader, Session $session, PluginInstaller $installer, Sniffer $sniffer, PasswordHash $passwordHash) {
            $this->lang         = $lang;
            $this->database     = $database;
            $this->bootLoader   = $bootLoader;
            $this->session      = $session;
            $this->installer    = $installer;
            $this->sniffer      = $sniffer;
            $this->passwordHash = $passwordHash;

            if ($this->database->isConnected()) {
                throw new FirstRunError($this->lang->getText('Database has already been setup. Please remove the database configuration file (\app\Config\db-config) before running this script.'));
            }
        }

        public function index() {
            return (new View());
        }

        public function setup(HttpRequestEx $request) {
            $params = $request->getParameters();

            try {
                if (!empty($params['db']['database']) && !empty($params['db']['username']) && !empty($params['db']['password'])) {
                    try {
                        $conn = $this->database->connect($params['db']);

                        if ($pdo = $conn->getPdo()) {
                            $conf = sprintf('%s/app/Config/db-config', $this->bootLoader->getBaseDir());

                            if (file_put_contents($conf, sprintf('mysql://%s:%s@%s/%s', $params['db']['username'], $params['db']['password'], $params['db']['host'], $params['db']['database']))) {
                                if ($this->installer->install(['minutephp/site'], 'require', true)) {
                                    $sth = $pdo->prepare('REPLACE INTO users SET email = :email, password = :password, ip_addr = :ip, created_at = NOW(), updated_at = NOW(), first_name = "Admin", verified = "true"');
                                    $sth->execute(['email' => sprintf('admin@%s', $params['site']['domain'] ?? 'localhost'), 'password' => $this->passwordHash->getHashedPassword(Str::random()),
                                                   'ip' => $this->sniffer->getUserIP()]);

                                    if ($admin_id = $pdo->lastInsertId()) {
                                        $sth = $pdo->prepare('REPLACE INTO m_user_groups set user_id = :user_id, group_name = "admin", created_at = NOW(), updated_at = NOW(), 
                                                                           expires_at = "20200101", credits = 999, comments = "First run"');
                                        $sth->execute(['user_id' => $admin_id]);

                                        $types = ['public' => $params['site'] ?? [], 'private' => []];

                                        foreach ($types as $type => $data) {
                                            $sth = $pdo->prepare('REPLACE INTO m_configs set type = :type, data_json = :data');
                                            $sth->execute(['type' => $type, 'data' => json_encode($data)]);
                                        }

                                        $this->session->startSession($admin_id);

                                        return 'pass';
                                    }
                                } else {
                                    throw new FirstRunError($this->lang->getText("Unable to run composer"));
                                }
                            }
                        }
                    } catch (\Throwable $e) {
                        throw new FirstRunError($this->lang->getText("Unable to connect to database.\n") . $e->getMessage());
                    }
                }

                throw new FirstRunError($this->lang->getText('All connection parameters are required. Please check connection details'));
            } catch (\Throwable $e) {
                if (!empty($conf) && file_exists($conf)) {
                    @unlink($conf);
                }

                throw new FirstRunError("Error: " . $e->getMessage());
            }
        }
    }
}