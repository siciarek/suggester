<?php
namespace Application\Frontend\Controller;

use Application\Common\Controller\CommonController;
use Application\Frontend\Entity\Suggestion;
use Application\Frontend\Form\SuggestionForm;

class DefaultController extends CommonController {

    /**
     * @Get("/", name="frontend.list")
     */
    public function listAction() {
        $this->view->items = Suggestion::find([
            'order' => 'created_at DESC',
        ]);
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
