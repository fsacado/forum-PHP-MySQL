<?php

namespace Loann\Model;

class Category
{
    /*
     * @var int
     */
    private $id;

    /*
     * @var string
     */
    private $name;
    

    /**
     * @param mixed $id
     * @return Category
     */
    public function getId()
    {
        return $this->id;
    }

    /* 
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}
