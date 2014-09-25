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

class User implements \Phalcon\DI\InjectionAwareInterface
{

    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;

    protected $user;

    private $expanded = [];

    protected function checkAccess($access)
    {

        $this->user = \Application\Frontend\Entity\User::findFirstByUsername($access->username);

        return $this->user instanceof \Application\Frontend\Entity\User
        and $this->getDi()->getSecurity()->checkHash($access->password, $this->user->getPassword());
    }

    public function expandRole($role)
    {
        $roles = $this->getDi()->getRoles();

        if (array_key_exists($role, $roles)) {
            if (is_array($roles[$role])) {
                foreach ($roles[$role] as $r) {
                    $this->expandRole($r, $this->expanded);
                }
            } else {
                if ($roles[$role] !== null) {
                    $this->expanded[] = $roles[$role];
                }
            }
            $this->expanded[] = $role;
        }

        return array_unique($this->expanded, SORT_STRING);
    }

    public function isGranted($role)
    {
        if ($this->isAuthenticated()) {
            return in_array($role, $this->get('roles'));
        }

        return $role === SecurePlugin::NOT_SECURED;
    }

    public function get($key)
    {
        if ($this->isAuthenticated()) {
            return $this->getDI()->getSession()->get('user')[$key];
        }
        return null;
    }

    public function logout()
    {
        $this->getDI()->getSession()->destroy();
    }

    public function authenticate($access)
    {

        if ($this->checkAccess($access)) {
            $u = new \Phalcon\Session\Bag('user');
            $u->setDI($this->getDI());
            $u->id = $this->user->getId();
            $u->username = $this->user->getUsername();
            $u->email = $this->user->getEmail();
            $u->firstName = $this->user->getFirstName();
            $u->lastName = $this->user->getLastName();
            $u->groups = [];
            $u->roles = \Symfony\Component\Yaml\Yaml::parse($this->user->getRoles());

            return true;
        }

        return false;
    }

    public function isAuthenticated()
    {
        return $this->getDI()->getSession()->has('user');
    }

    /**
     * Sets the dependency injector
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return \Phalcon\DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }
}