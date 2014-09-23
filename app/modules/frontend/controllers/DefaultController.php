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
     * @Get("/suggestions.{format:html|xls|xlsx}}", name="frontend.list_export")
     */
    public function listAction($format = 'html') {


        $data = $this->modelsManager->createBuilder()
            ->addFrom('Application\Frontend\Entity\Suggestion', 's')
            ->orderBy('s.created_at DESC');

        if ($format !== 'html') {

            return $this->getExcelResponse($format, $data);

        } else {

            $type = [];

            foreach (SuggestionType::find()->toArray() as $t) {
                $type[$t['id']] = $t['name'];
            }

            $this->view->type = $type;

            $currentPage = abs($this->request->getQuery('page', 'int', 1));

            if ($currentPage == 0) {
                $currentPage = 1;
            }

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
    }

    /**
     * @param $format
     * @param $data
     * @return \Phalcon\Http\ResponseInterface
     */
    public function getExcelResponse($format, $data) {

        /**
         * @var \Phalcon\Translate\Adapter\NativeArray $trans
         */
        $trans = $this->getDI()->getTrans();
        $fname = sprintf('%s.%s', 'suggestions', $format);
        $tmpdir = $this->getDI()->getConfig()->dirs->temp;
        $tmpfname = tempnam($tmpdir, 'XLS');

        $params = $this->view->getParamsToView();
        $creator = sprintf('%s %s', $params['app_name'], $params['app_version']);

        $source = $data->getQuery()->execute()->toArray();

        $xls = new \PHPExcel();
        $sheet = $xls
            ->getActiveSheet()
            ->setTitle($trans->query('suggestion.list'));

        if (count($source) > 0) {
            $headers = array_map(function ($e) use ($trans) {
                return $trans->query('suggestion.' . $e);
            }, array_keys($source[0]));

            array_unshift($source, $headers);

            $sheet
                ->setSelectedCellByColumnAndRow(0, 1)
                ->fromArray(
                    $source
                );

            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var \PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }

            $sheet->getStyle('1:1')->getFont()->setBold(true);
            $sheet->setAutoFilterByColumnAndRow(0, 1, count($headers) - 1, $sheet->getHighestDataRow());
        }

        \PHPExcel_IOFactory::createWriter($xls, $format === 'xls' ? 'Excel5' : 'Excel2007')
            ->save($tmpfname);


        $contentType = $format === 'xls' ? 'application/vnd.ms-excel' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        $content = file_get_contents($tmpfname);

        $headers = array(
            'Content-length' => filesize($tmpfname),
            'Content-Disposition' => 'attachment;filename="' . $fname . '"',
            'Cache-Control' => 'max-age=0',
            'Pragma' => 'public',
        );

        foreach ($headers as $name => $value) {
            $this->response->setHeader($name, $value);
        }

        return $this->response
            ->setStatusCode(200, 'OK')
            ->setContentType($contentType)
            ->setContent($content);
    }

    /**
     * @Route("/remove/{id:[1-9]\d*}", name="frontend.remove")
     */
    public function removeAction($id) {

        $item = Suggestion::findFirst(['id = ' . $id . '',]);

        if ($item instanceof Suggestion) {
            // TODO: handle exception
            $item->delete();
        }

        $url = $this->request->getHTTPReferer();
        $url = trim($url);
        $url = empty($url) ? $url : $this->getDI()->getUrl()->get(['for' => 'frontend.list']);

        $this->response->redirect($url, true);
    }

    /**
     * @Route("/form", name="frontend.form")
     */
    public function formAction() {

        $data = $_POST;

        $options = [
            'application' => $this->request->get('application'),
            'page_url' => $this->request->get('page_url'),
            'author' => $this->request->get('author') ? : $this->getDI()->getTrans()->query('common.anonymous'),
        ];

        // Routing with parameters fix:
        foreach ($_GET as $key => $val) {
            if ($key === '_url') {
                continue;
            }

            if (!array_key_exists($key, $options)) {
                $par = '&' . $key . '=' . $val;
                if (!preg_match(('/&' . $key . '=/'), $options['page_url'])) {
                    $options['page_url'] .= $par;
                }
            }
        }

        $form = new SuggestionForm(new Suggestion(), $options);

        if ($this->request->getMethod() === 'POST') {
            $entity = $form->getEntity();
            $form->bind($data, $entity);
            if ($form->isValid()) {
                $entity->setAgent($this->request->getUserAgent());
                $entity->setCreatedAt(date('Y-m-d H:i:s'));
                $entity->save();

                $router = $this->getDi()->getUrl();

                $url = $router->get(['for' => 'frontend.prompt']) . '?' .
                    http_build_query($options);
                $url = sprintf('%s://%s%s', $this->request->getScheme(), $this->request->getHttpHost(), $url);

                return $this->response->redirect($url, false);
            }
        }

        $this->view->form = $form;
    }

    /**
     * @Get("/prompt", name="frontend.prompt")
     */
    public function promptAction() {

        $options = [
            'application' => $this->request->get('application'),
            'page_url' => $this->request->get('page_url'),
            'author' => $this->request->get('author') ? : $this->getDI()->getTrans()->query('common.anonymous'),
        ];

        $this->view->options = $options;
    }
}
