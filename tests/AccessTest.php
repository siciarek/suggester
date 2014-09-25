<?php

class standardClass
{
    public $username;
    public $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}

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
            [true,  new standardClass('czesolak', 'password'), 'The user logs in with the correct access data.'],
            [false, new standardClass('incorrect', 'password'), 'The user logs in with the incorrect username.'],
            [false, new standardClass('czesolak', 'incorrect'), 'The user logs in with the incorrect password.'],
            [false, new standardClass(null, null), 'The user logs in with nulls.'],
            [false, new standardClass('', ''), 'The user logs in with empty strings.'],
        ];
    }

    public static function rolesDataProvider()
    {
        return [
            [true,  'ROLE_USER', new standardClass('czesolak', 'password'), 'The user logs in with the correct access data.'],
            [false, 'ROLE_USER', new standardClass('incorrect', 'password'), 'The user logs in with the incorrect username.'],
            [false, 'ROLE_USER', new standardClass('czesolak', 'incorrect'), 'The user logs in with the incorrect password.'],
            [false, 'ROLE_USER', new standardClass(null, null), 'The user logs in with nulls.'],
            [false, 'ROLE_USER', new standardClass('', ''), 'The user logs in with empty strings.'],

            [false, 'ROLE_ADMIN', new standardClass('czesolak', 'password'), 'The user logs in with the correct access data but has not granted a role.'],
            [true,  'ROLE_ADMIN', new standardClass('mariolak', 'password'), 'The user logs in with the correct access data and has granted a role.'],
            [true,  'ROLE_USER',  new standardClass('mariolak', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
            [true,  'IS_AUTHENTICATED_ANONYMOUSLY',  new standardClass('mariolak', 'password'), 'The user logs in with the correct access data and has granted dependent role.'],
        ];
    }

    public static function expandRoleDataProvider()
    {
        return [
            ['IS_AUTHENTICATED_ANONYMOUSLY', ['IS_AUTHENTICATED_ANONYMOUSLY']],
            ['ROLE_USER', ['ROLE_USER', 'IS_AUTHENTICATED_ANONYMOUSLY']],
            ['ROLE_ADMIN', ['ROLE_ADMIN', 'ROLE_USER', 'IS_AUTHENTICATED_ANONYMOUSLY']],
            ['ROLE_ALLOWED_TO_READ_OWN_ARTICLE', ['IS_AUTHENTICATED_ANONYMOUSLY','ROLE_USER','ROLE_ALLOWED_TO_READ_OWN_ARTICLE']],
            ['ROLE_ALLOWED_TO_READ_ARTICLE', ['IS_AUTHENTICATED_ANONYMOUSLY','ROLE_USER','ROLE_ALLOWED_TO_READ_OWN_ARTICLE','ROLE_ALLOWED_TO_READ_ARTICLE']],
            ['NONEXISTING_ROLE', []],
        ];
    }

    /**
     * @dataProvider loginDataProvider
     */
    public function testLogin($expected, $accessData, $message)
    {
        $given = $this->di->getUser()->authenticate($accessData);
        $this->assertEquals($expected, $given, $message);
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
        $_SESSION = array();

        $this->di->getUser()->authenticate($accessData);
        $given = $this->di->getUser()->isGranted($role);
        $this->assertEquals($expected, $given, $message);
    }
}
