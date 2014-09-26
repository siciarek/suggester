<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 23.09.14
 * Time: 08:25
 */

namespace Application\Common\Plugin;

use Phalcon\Exception;

class SecurePlugin extends \Phalcon\Mvc\User\Plugin {
    const ANNOTATION_NAME = 'Secure';

    /**
     * To zdarzenie jest wywoływane przed wykonaniem każdego routingu w dispatcherze
     */
    public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher) {
        $controller = get_class($dispatcher->getActiveController());
        $action = $dispatcher->getActiveMethod();

        // Wyłuskaj adnotacje przypisane do bieżącego kontrolera:
        $annotations['controller'] = $this->annotations->get($controller)->getClassAnnotations();

        // Wyłuskaj adnotacje przypisane do bieżącej akcji:
        $annotations['action'] = $this->annotations->getMethod($controller, $action);

        $roles = [];

        /**
         * @var \Phalcon\Annotations\Collection $collection
         */
        foreach ($annotations as $key => $collection) {
            if ($collection instanceof \Phalcon\Annotations\Collection and $collection->has(self::ANNOTATION_NAME)) {
                $roles[$key] = $collection->get(self::ANNOTATION_NAME)->getArguments();
            }
        }

        // Jeżeli nie ma żadnych zabezpieczeń lub akcja nie jest zabezpieczona:
        if (count($roles) === 0 or (array_key_exists('action', $roles) and in_array(\Application\Common\User::NOT_SECURED, $roles['action']))) {
            return true;
        }

        $required = [];

        // Tworzenie listy wymaganych ról dla danej akcji - adnotacje akcji mają wyższy priorytet niż adnotacje kontrolera:
        if (array_key_exists('action', $roles)) {
            $required = $roles['action'];
        } else {
            if (false == in_array(\Application\Common\User::NOT_SECURED, $roles['controller'])) {
                $required = $roles['controller'];
            }
        }

        $access = false;

        foreach ($required as $role) {
            if ($this->getDI()->getUser()->isGranted($role)) {
                $access = true;
                break;
            }
        }

        if ($access === false) {
            // If user is logged in and tries to access forbiden page:
            if ($this->getDI()->getUser()->isAuthenticated() and $controller !== '\Application\Common\Controller\Error') {
                return $dispatcher->getActiveController()->response->redirect(['for' => 'error.access_forbiden']);
            } else {
                $route = $dispatcher->getActiveController()->router->getMatchedRoute()->getName();
                $params = $dispatcher->getActiveController()->router->getParams();

                $this->getDI()->getSession()->set('$TARGET$', (['for' => $route ] + $params));
                return $dispatcher->getActiveController()->response->redirect(['for' => 'user.sign_in']);
            }
        }

        return true;
    }
}
