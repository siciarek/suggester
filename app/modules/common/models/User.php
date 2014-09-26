<?php
/**
 * Created by JetBrains PhpStorm.
 * User: siciarek
 * Date: 24.09.14
 * Time: 21:24
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Common;

use Application\Common\Exceptions\InvalidAccessDataException;
use Application\Common\Exceptions\UserDisabledException;

class User implements \Phalcon\DI\InjectionAwareInterface
{

    const SESSION_KEY = '$PHALCON/USER$';
    const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const NOT_SECURED = 'IS_AUTHENTICATED_ANONYMOUSLY';

    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;
    protected $user;
    private $expanded = [];

    protected function checkAccess(Access $access)
    {
        $this->user = \Application\Frontend\Entity\User::findFirstByUsername($access->username);

        if($this->user instanceof \Application\Frontend\Entity\User && $this->user->getEnabled() == false) {
            throw new UserDisabledException();
        }

        $authenticated = true;
        $authenticated &= $this->user instanceof \Application\Frontend\Entity\User;
        $authenticated &= $authenticated && $this->getDi()->getSecurity()->checkHash($access->password, $this->user->getPassword());

        if($authenticated == false) {
            throw new InvalidAccessDataException();
        }

        return true;
    }

    public function expandRole($role)
    {
        $roles = $this->getDi()->getRoles();

        if (array_key_exists($role, $roles->assoc)) {

            $this->expanded[] = $role;

            if (array_key_exists($role, $roles->hierarchy) && is_array($roles->hierarchy[$role])) {
                foreach ($roles->hierarchy[$role] as $r) {
                    $this->expandRole($r, $this->expanded);
                }
            }
        }

        return array_unique($this->expanded, SORT_STRING);
    }

    public function getNormalizedRoles(\Application\Frontend\Entity\User $user)
    {
        $roles = \Symfony\Component\Yaml\Yaml::parse($user->getRoles());
        foreach ($user->groups as $g) {
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

    public function getGroupsNames(\Application\Frontend\Entity\User $user) {
        $groups = [];

        foreach ($user->groups as $g) {
            $groups[] = $g->getName();
        }

        return $groups;
    }

    public function isGranted($role)
    {
        if ($this->isAuthenticated()) {
            return in_array(self::SUPER_ADMIN, $this->get('roles')) or in_array($role, $this->get('roles'));
        }
        return $role === self::NOT_SECURED;
    }

    public function get($key)
    {
        if ($this->isAuthenticated()) {
            return $this->getDI()->getSession()->get(self::SESSION_KEY)[$key];
        }
        return null;
    }

    public function logout()
    {
        if ($this->isAuthenticated()) {
            $this->getDI()->getSession()->remove(self::SESSION_KEY);
        }
    }

    public function authenticate($access)
    {
        if ($this->checkAccess($access)) {
            $u = new \Phalcon\Session\Bag(self::SESSION_KEY);
            $u->setDI($this->getDI());
            $u->id = $this->user->getId();
            $u->username = $this->user->getUsername();
            $u->gender = $this->user->getGender();
            $u->description = $this->user->getDescription();
            $u->email = $this->user->getEmail();
            $u->firstName = $this->user->getFirstName();
            $u->lastName = $this->user->getLastName();
            $u->groups = $this->getGroupsNames($this->user);
            $u->roles = $this->getNormalizedRoles($this->user);

            return true;
        }

        return false;
    }

    public function isAuthenticated()
    {
        return $this->getDI()->getSession()->has(self::SESSION_KEY);
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
