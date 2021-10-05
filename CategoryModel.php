<?php
require_once "Database/Database.php";

class CategoryModel
{
    private $id;
    private $name;

    /**
     * CategoryModel constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public static function getCategories()
    {
        $sql = 'select * from categories';
        return Database::getData($sql);
    }
    public static function getCategory($categoryID)
    {
        $sql = 'select * from categories where categoryID = ' . $categoryID;
        return Database::getData($sql)[0];
    }
}