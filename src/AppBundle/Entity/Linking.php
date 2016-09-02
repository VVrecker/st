<?php

namespace AppBundle\Entity;

/**
 * Linking
 */
class Linking
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $categories;

    /**
     * @var int
     */
    private $goods;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categories
     *
     * @param integer $categories
     *
     * @return Linking
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return int
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set goods
     *
     * @param integer $goods
     *
     * @return Linking
     */
    public function setGoods($goods)
    {
        $this->goods = $goods;

        return $this;
    }

    /**
     * Get goods
     *
     * @return int
     */
    public function getGoods()
    {
        return $this->goods;
    }
}

