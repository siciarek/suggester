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
use Application\Backend\Form\UserForm;

/**
 * @RoutePrefix('/user')
 */
class UserController extends CommonController
{
    /**
     * @Route("/toggle/{id:[1-9]\d*}", name="backend.user.toggle")
     */
    public function toggleAction($id) {
        /**
         * @var User $user
         */
        $user = User::findFirst($id);

        if($user instanceof User) {
            $user->setEnabled(intval(!$user->getEnabled()))->save();
        }

        $url = $this->getReferer(['for' => 'backend.user.list']);

        return $this->response->redirect($url, true);
    }

    /**
     * @Route("/create", name="backend.user.create")
     * @Route("/edit/{id:[1-9]\d*}", name="backend.user.edit")
     */
    public function editAction($id = 0) {
        /**
         * @var User $user
         */
        $user = $id === 0 ? new User() : User::findFirst($id);

        if(!$user instanceof User) {
            throw new \Application\Common\Exceptions\NotFoundException();
        }

        $this->view->form = new UserForm($user);

    }

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
