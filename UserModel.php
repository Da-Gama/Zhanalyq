<?php
require_once "Database/Database.php";

class UserModel
{
    private $id;
    private $firstName;
    private $lastName;
    private $birthDay;
    private $email;
    private $password;

    /**
     * UserModel constructor.
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $birthDay
     * @param $email
     * @param $password
     */
    public function __construct($id, $firstName, $lastName, $birthDay, $email, $password)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDay = $birthDay;
        $this->email = $email;
        $this->password = $password;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * @param mixed $birthDay
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    private static function getPublicationsCount($user_id){
        $sql = "SELECT COUNT(publicationID) AS total FROM publications where userID = " . $user_id;
        return Database::getData($sql)[0]['total'];
    }

    private static function getCommentsCount($user_id){
        $sql = "SELECT COUNT(commentID) AS total FROM comments where userID = " . $user_id;
        return Database::getData($sql)[0]['total'];
    }

    public static function getUser($userID){
        $sql = 'select * from users where userID = ' . $userID;
        $result = Database::getData($sql)[0];
        $result['comments'] = self::getCommentsCount($userID);
        $result['publications'] = self::getPublicationsCount($userID);
        return $result;
    }

    public static function createUser($firstName, $lastName, $email, $password, $birthday){
        $sql = 'INSERT INTO users(firstName, lastName, email, password, birthday) 
            values ("'.$firstName.'", "'.$lastName.'", "'.$email.'", "'.$password.'", "'.$birthday.'")';
        if (Database::executeData($sql)){
            return 1;
        }
        return 0;
    }



}