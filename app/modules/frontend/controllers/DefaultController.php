<?php
namespace Application\Frontend\Controller;

use Application\Common\Controller\CommonController;
use Application\Frontend\Entity\Suggestion;
use Application\Frontend\Entity\SuggestionType;
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
            ->addFrom('Application\Frontend\Entity\Suggestion', 's')
            ->orderBy('s.created_at DESC')
        ;

        $type = [];

        foreach(SuggestionType::find()->toArray() as $t) {
            $type[$t['id']] = $t['name'];
        }

        $this->view->type = $type;

        $this->view->items = new Pager(
            new Paginator(array(
                'builder' => $data,
                'limit' => $this->getDI()->getConfig()->pager->limit,
                'page' => $currentPage,
            )),
            array(
                'layoutClass' => 'Phalcon\Paginator\Pager\Layout\Bootstrap',
                'rangeLength' => $this->getDI()->getConfig()->pager->length,
                'urlMask' => '?page={%page_number}',
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
