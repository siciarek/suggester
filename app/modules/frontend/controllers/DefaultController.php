<?php
namespace Application\Frontend\Controller;

use Application\Common\Controller\CommonController;
use Application\Frontend\Entity\Suggestion;
use Application\Frontend\Form\SuggestionForm;
use Phalcon\Paginator\Pager;
use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;

class DefaultController extends CommonController {

    /**
     * @Get("/", name="frontend.list")
     */
    public function listAction() {

        $currentPage = abs($this->request->getQuery('page', 'int', 1));

        if ($currentPage == 0) {
            $currentPage = 1;
        }

        $data = $this->modelsManager->createBuilder()
            ->addFrom('\Application\Frontend\Entity\Suggestion', 's')
            ->orderBy('s.created_at DESC')
        ;

        $this->view->items = new Pager(
            new Paginator(array(
                'builder' => $data,
                'limit' => $this->getDI()->getConfig()->pager->limit,
                'page' => $currentPage,
            )),
            array(
                // We will use Bootstrap framework styles
                'layoutClass' => 'Phalcon\Paginator\Pager\Layout\Bootstrap',
                // Range window will be 5 pages
                'rangeLength' => $this->getDI()->getConfig()->pager->length,
                // Just a string with URL mask
                'urlMask' => '?page={%page_number}',
                // Or something like this
                // 'urlMask'     => sprintf(
                //     '%s?page={%%page_number}',
                //     $this->url->get(array(
                //         'for'        => 'index:posts',
                //         'controller' => 'index',
                //         'action'     => 'index'
                //     ))
                // ),
            )
        );
    }

    /**
     * @Get("/form", name="frontend.form")
     * @Post("/form")
     */
    public function formAction() {

        $data = $_POST;
        $options = [
            'application' => $this->request->get('application'),
            'author' => $this->request->get('author') ? : $this->getDI()->getTrans()->query('common.anonymous'),
        ];

        $form = new SuggestionForm(new Suggestion(), $options);

        if ($this->request->getMethod() === 'POST') {
            $entity = $form->getEntity();
            $form->bind($data, $entity);
            if ($form->isValid()) {
                $entity->setCreatedAt(date('Y-m-d H:i:s'));
                $entity->save();
                return $this->response->redirect(['for' => 'frontend.prompt']);
            }
        }

        $this->view->form = $form;
    }

    /**
     * @Get("/prompt", name="frontend.prompt")
     */
    public function promptAction() {

    }
}
