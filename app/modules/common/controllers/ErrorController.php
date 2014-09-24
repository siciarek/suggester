<?php
namespace Application\Common\Controller;

class ErrorController extends CommonController {

    public function notFoundAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('Error/notFound');
    }

    /**
     * @Get("/access-forbiden", name="error.access_forbiden")
     */
    public function forbidenAction()
    {
        $this->response->setStatusCode(403, 'Forbiden');
    }
}
