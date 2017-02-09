<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\FirstRun {

    use App\Model\User;
    use Minute\Error\UserUpdateDataError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserUpdateDataEvent;
    use Minute\Password\PasswordHash;
    use Minute\Session\Session;

    class Complete {
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var PasswordHash
         */
        private $passwordHash;

        /**
         * Complete constructor.
         *
         * @param Session $session
         * @param Dispatcher $dispatcher
         * @param PasswordHash $passwordHash
         */
        public function __construct(Session $session, Dispatcher $dispatcher, PasswordHash $passwordHash) {
            $this->session      = $session;
            $this->dispatcher   = $dispatcher;
            $this->passwordHash = $passwordHash;
        }

        public function update($email, $password) {
            if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($user = User::find($this->session->getLoggedInUserId())) {
                    $event = new UserUpdateDataEvent($user, ['email' => $email, 'password' => $this->passwordHash->getHashedPassword($password)]);
                    $this->dispatcher->fire(UserUpdateDataEvent::USER_UPDATE_DATA, $event);

                    if ($event->isHandled()) {
                        return 'pass';
                    }
                }
            }

            throw new UserUpdateDataError("Unable to update credentials");
        }
    }
}