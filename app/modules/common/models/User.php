<?php
/**
 * Created by JetBrains PhpStorm.
 * User: siciarek
 * Date: 24.09.14
 * Time: 21:24
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Common;


use Application\Common\Plugin\SecurePlugin;

class User implements \Phalcon\DI\InjectionAwareInterface {

    const SESSION_KEY = '$PHALCON/USER$';
    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;
    protected $user;
    private $expanded = [];

    protected function checkAccess($access) {
        $this->user = \Application\Frontend\Entity\User::findFirstByUsername($access->username);

        $authenticated =
            $this->user instanceof \Application\Frontend\Entity\User
            and $this->getDi()->getSecurity()->checkHash($access->password, $this->user->getPassword());

        return $authenticated;
    }

    public function expandRole($role) {
        $roles = $this->getDi()->getRoles();

        if (array_key_exists($role, $roles->assoc)) {
            if (is_array($roles->chierarchy[$role])) {
                foreach ($roles->chierarchy[$role] as $r) {
                    $this->expandRole($r, $this->expanded);
                }
            } else {
                if ($roles->chierarchy[$role] !== null) {
                    $this->expanded[] = $roles->chierarchy[$role];
                }
            }
            $this->expanded[] = $role;
        }

        return array_unique($this->expanded, SORT_STRING);
    }

    public function getNormalizedRoles(\Application\Frontend\Entity\User $user) {
        $roles = \Symfony\Component\Yaml\Yaml::parse($user->getRoles());
        foreach($user->groups as $g) {
            $temp = \Symfony\Component\Yaml\Yaml::parse($g->getRoles());
            $roles = array_unique(array_merge($temp, $roles), SORT_STRING);
        }
        $output = [];

        foreach ($roles as $role) {
            $data = $this->expandRole($role);
            $output = array_unique(array_merge($output, $data), SORT_STRING);
        }

        return $output;
    }

    public function isGranted($role) {
        if ($this->isAuthenticated()) {
            return in_array($role, $this->get('roles'));
        }
        return $role === SecurePlugin::NOT_SECURED;
    }

    public function get($key) {
        if ($this->isAuthenticated()) {
            return $this->getDI()->getSession()->get(self::SESSION_KEY)[$key];
        }
        return null;
    }

    public function logout() {
        $this->getDI()->getSession()->destroy();
    }

    public function authenticate($access) {
        if ($this->checkAccess($access)) {
            $u = new \Phalcon\Session\Bag(self::SESSION_KEY);
            $u->setDI($this->getDI());
            $u->id = $this->user->getId();
            $u->username = $this->user->getUsername();
            $u->email = $this->user->getEmail();
            $u->firstName = $this->user->getFirstName();
            $u->lastName = $this->user->getLastName();
            $u->groups = [];
            $u->roles = $this->getNormalizedRoles($this->user);

            return true;
        }

        return false;
    }

    public function isAuthenticated() {
        return $this->getDI()->getSession()->has(self::SESSION_KEY);
    }

    /**
     * Sets the dependency injector
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function setDI($dependencyInjector) {
        $this->di = $dependencyInjector;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return \Phalcon\DiInterface
     */
    public function getDI() {
        return $this->di;
    }
}
