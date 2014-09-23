<?php

namespace Application\Frontend\Entity;

class Suggestion extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $type_id;

    /**
     *
     * @var string
     */
    protected $priority;

    /**
     *
     * @var string
     */
    protected $application;

    /**
     *
     * @var string
     */
    protected $author;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @var string
     */
    protected $page_url;

    /**
     *
     * @var string
     */
    protected $agent;

    /**
     *
     * @var string
     */
    protected $created_at;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field type_id
     *
     * @param integer $type_id
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Method to set the value of field priority
     *
     * @param string $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Method to set the value of field application
     *
     * @param string $application
     * @return $this
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Method to set the value of field author
     *
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Method to set the value of field page_url
     *
     * @param string $page_url
     * @return $this
     */
    public function setPageUrl($page_url)
    {
        $this->page_url = $page_url;

        return $this;
    }

    /**
     * Method to set the value of field agent
     *
     * @param string $agent
     * @return $this
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Method to set the value of field created_at
     *
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field type_id
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Returns the value of field priority
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Returns the value of field application
     *
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Returns the value of field author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the value of field page_url
     *
     * @return string
     */
    public function getPageUrl()
    {
        return $this->page_url;
    }

    /**
     * Returns the value of field agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Returns the value of field created_at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getSource()
    {
        return 'suggestion';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'type_id' => 'type_id', 
            'priority' => 'priority', 
            'application' => 'application', 
            'author' => 'author', 
            'content' => 'content', 
            'page_url' => 'page_url', 
            'agent' => 'agent', 
            'created_at' => 'created_at'
        );
    }

}
