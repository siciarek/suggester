<?php

namespace Application\Frontend\Entity;

class UserGroup extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo('user_id', 'Application\Frontend\Entity\User', 'id',
            array('alias' => 'user', 'foreignKey' => array(
                'user.error.no_such_user',
            )));
        $this->belongsTo('group_id', 'Application\Frontend\Entity\Group', 'id',
            array('alias' => 'group', 'foreignKey' => array(
                'group.error.no_such_group',
            )));
    }

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     *
     * @var integer
     */
    protected $group_id;

    /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field group_id
     *
     * @param integer $group_id
     * @return $this
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;

        return $this;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field group_id
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    public function getSource()
    {
        return 'user_group';
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'user_id' => 'user_id', 
            'group_id' => 'group_id'
        );
    }

}
