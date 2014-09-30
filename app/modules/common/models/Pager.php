<?php

namespace Application\Common;

class Pager implements \Phalcon\DI\InjectionAwareInterface
{
    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;

    public function get(\Phalcon\Mvc\Model\Query\Builder $builder, $page)
    {
        $config = $this->di->getConfig()->pager;

        // TODO: obkumać dlaczego przestało działać, może pojawi się nowa wersja inkubatora.
        $adapter = new \Phalcon\Paginator\Adapter\QueryBuilder(array(
            'builder' => $builder,
            'limit' => $config->limit,
            'page' => $page,
        ));

        $adapter = new \Phalcon\Paginator\Adapter\Model(array(
            'data' => $builder->getQuery()->execute(),
            'limit' => intval($config->limit),
            'page' => $page,
        ));

        return new \Phalcon\Paginator\Pager(
            $adapter,
            array(
                'layoutClass' => 'Phalcon\Paginator\Pager\Layout\Bootstrap',
                'rangeLength' => intval($config->length),
                'urlMask' => '?page={%page_number}',
            )
        );
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