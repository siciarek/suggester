<?php

use \Application\Common\Access;

/**
 * User access test
 *
 * Class AccessTest
 */
class AccessTest extends \Application\Test\UnitTestCase
{
    public static function loginDataProvider()
    {
        return [
            [true,  new Access('czesolak', 'password'), 'The user logs in with the correct access data.'],
            [false, new Access('incorrect', 'password'), 'The user logs in with the incorrect username.'],
            [false, new Access('czesolak', 'incorrect'), 'The user logs in with the incorrect password.'],
            [false, new Access(null, null), 'The user logs in with nulls.'],
            [false, new Access('', ''), 'The user logs in with empty strings.'],
        ];
    }

    public static function rolesDataProvider()
    {
        return [
            [true, 'IS_AUTHENTICATED_ANONYMOUSLY', new Access('', ''), 'User is not logged in but wants to access public area.'],

            [true,  'ROLE_USER', new Access('czesolak', 'password'), 'The user logs in with the correct access data.'],
            [false, 'ROLE_USER', new Access('incorrect', 'password'), 'The user logs in with the incorrect username.'],
            [false, 'ROLE_USER', new Access('czesolak', 'incorrect'), 'The user logs in with the incorrect password.'],
            [false, 'ROLE_USER', new Access(null, null), 'The user logs in with nulls.'],
            [false, 'ROLE_USER', new Access('', ''), 'The user logs in with empty strings.'],

            [false, 'ROLE_ADMIN', new Access('czesolak', 'password'), 'The user logs in with the correct access data but has not granted a role.'],

            [true,  'ROLE_ADMIN', new Access('mariolak', 'password'), 'The user logs in with the correct access data and has granted a role.'],
            [true,  'ROLE_USER',  new Access('mariolak', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
            [true,  'IS_AUTHENTICATED_ANONYMOUSLY',  new Access('mariolak', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],

            [true,  'ROLE_SUPER_ADMIN', new Access('hasim', 'password'), 'The user logs in with the correct access data and has granted a role.'],
            [true,  'ROLE_ADMIN',  new Access('hasim', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
            [true,  'ROLE_ALLOWED_TO_SWITCH',  new Access('hasim', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
            [true,  'ROLE_USER',  new Access('hasim', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
            [true,  'IS_AUTHENTICATED_ANONYMOUSLY',  new Access('hasim', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
            [true,  'ROLE_PRIVILEGED_ARTICLE_EDITOR',  new Access('hasim', 'password'), 'The user has granted role because has ROLE_SUPER_ADMIN role.'],
        ];
    }

    public static function expandRoleDataProvider()
    {
        return [
            [null, []],
            ['', []],
            ['                 ', []],
            ['NONEXISTING_ROLE', []],
            ['IS_AUTHENTICATED_ANONYMOUSLY', ['IS_AUTHENTICATED_ANONYMOUSLY']],
            ['ROLE_USER', ['ROLE_USER', 'IS_AUTHENTICATED_ANONYMOUSLY']],
            ['ROLE_ADMIN', ['ROLE_ADMIN', 'ROLE_USER', 'IS_AUTHENTICATED_ANONYMOUSLY']],
            ['ROLE_SUPER_ADMIN', ['IS_AUTHENTICATED_ANONYMOUSLY','ROLE_USER','ROLE_ADMIN','ROLE_ALLOWED_TO_SWITCH','ROLE_SUPER_ADMIN']],

            ['ROLE_ALLOWED_TO_READ_OWN_ARTICLE', ['IS_AUTHENTICATED_ANONYMOUSLY','ROLE_USER','ROLE_ALLOWED_TO_READ_OWN_ARTICLE']],
            ['ROLE_ALLOWED_TO_READ_ARTICLE', ['IS_AUTHENTICATED_ANONYMOUSLY','ROLE_USER','ROLE_ALLOWED_TO_READ_OWN_ARTICLE','ROLE_ALLOWED_TO_READ_ARTICLE']],
        ];
    }

    /**
     * @dataProvider loginDataProvider
     */
    public function testLogin($expected, $accessData, $message)
    {
        /**
         * Mock session
         */
        $_SESSION = array();

        $given = $this->di->getUser()->authenticate($accessData);
        $this->assertEquals($expected, $given, $message);
        $this->assertEquals($expected, $this->di->getUser()->isAuthenticated(), 'IS AUTHENTICATED ' . $message);
        $this->assertEquals($this->di->getUser()->isAuthenticated() ? $accessData->username : null, $this->di->getUser()->get('username'), 'GET PARAMETER ' . $message);

        $this->di->getUser()->logout();
        $this->assertEquals(false, $this->di->getUser()->isAuthenticated(), 'IS NOT AUTHENTICATED ' . $message);
    }

    /**
     * @dataProvider expandRoleDataProvider
     */
    public function testExpandRole($role, $expected)
    {
        $given = $this->di->getUser()->expandRole($role);

        $this->assertEquals(count($expected), count($given), json_encode($given));

        foreach($expected as $e) {
            $this->assertTrue(in_array($e, $given));
        }
    }

    /**
     * @dataProvider rolesDataProvider
     */
    public function testRoles($expected, $role, $accessData, $message)
    {
        /**
         * Mock session
         */
        $_SESSION = array();

        $this->di->getUser()->authenticate($accessData);
        $given = $this->di->getUser()->isGranted($role);
        $this->assertEquals($expected, $given, $message);
    }
}
