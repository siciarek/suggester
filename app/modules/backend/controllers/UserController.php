<?php
namespace Application\Backend\Controller;

use Application\Common\Controller\CommonController;
use Application\Frontend\Entity\Suggestion;
use Application\Frontend\Entity\SuggestionType;
use Application\Frontend\Entity\User;
use Application\Frontend\Form\SuggestionForm;
use Application\Frontend\Form\UserSignInForm;
use Phalcon\Paginator\Pager;
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Application\Common\Exceptions\InvalidAccessDataException;
use Application\Common\Exceptions\UserDisabledException;

/**
 * @RoutePrefix('/user')
 */
class UserController extends CommonController
{
    /**
     * @Route("/list", name="backend.user.list")
     */
    public function listAction() {
        $data = new \stdClass();

        $data->users = $this->modelsManager
            ->createBuilder()
            ->addFrom('Application\Frontend\Entity\User', 'u')
            ->orderBy('u.id DESC');

        $data->groups =  $this->modelsManager
            ->createBuilder()
            ->addFrom('Application\Frontend\Entity\Group', 'g')
            ->orderBy('g.name ASC');

        $currentPage = abs($this->request->getQuery('page', 'int', 1));

        if ($currentPage == 0) {
            $currentPage = 1;
        }

        $users = (new Pager(
            new \Phalcon\Paginator\Adapter\QueryBuilder(array(
                'builder' => $data->users,
                'limit' => $this->getDI()->getConfig()->pager->limit,
                'page' => $currentPage,
            )),
            array(
                'layoutClass' => 'Phalcon\Paginator\Pager\Layout\Bootstrap',
                'rangeLength' => $this->getDI()->getConfig()->pager->length,
                'urlMask' => '?page={%page_number}',
            )
        ))
            ->getIterator()
            ->toArray();

        $groups = $data->groups->getQuery()->execute()->toArray();

        $this->view->users = $users;
        $this->view->groups = $groups;
    }
}
