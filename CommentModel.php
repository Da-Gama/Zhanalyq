<?php
require_once "Database/Database.php";

class CommentModel
{
    private $id;
    private $content;
    private $author;
    private $publication;
    private $date;

    public function __construct($id, $content, $author, $publication, $date)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
        $this->publication = $publication;
        $this->date = $date;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param mixed $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public static function getCommentCount($publicationID)
    {
        $sql = 'SELECT COUNT(1) FROM comments WHERE publicationID = ' . $publicationID;
        return Database::getData($sql)[0]['COUNT(1)'];
    }

    public static function createComment($userID, $publicationID, $content)
    {
        $sql = 'insert into comments (userID, publicationID, commentContent) values ('.$userID.', '.$publicationID.', "'.$content.'")';
        if (Database::executeData($sql)){
            $sql2 = 'update publications set commented = commented + 1 where publicationID = ' . $publicationID;
            if (Database::executeData($sql2)){
                return 1;
            }else{
                return null;
            }
        }
        return null;
    }

    public static function getComment($commentID)
    {
        $sql = 'select * from comments where commentID = ' . $commentID;
        return Database::getData($sql)[0];
    }

    public static function getComments($publicationID)
    {
        $sql = 'select * from comments c inner join users u on c.userID = u.userID where c.publicationID = ' . $publicationID . ' order by c.date_ desc';
        return Database::getData($sql);
    }

    public static function removeComment($commentID, $publicationID){
        $sql = 'delete from comments where commentID = ' . $commentID;
        if (Database::executeData($sql)){
            $sql2 = 'update publications set commented = commented - 1 where publicationID = '. $publicationID;
            if (Database::executeData($sql2)){
                return 1;
            }else{
                return null;
            }
        }
        return null;
    }

    public static function updateComment($commentID, $content)
    {
        $sql = 'update comments set commentContent = "'.$content.'" where commentID = ' . $commentID;
        if (Database::executeData($sql)){
            return 1;
        }
        return null;
    }

    public static function isMyComment($author, $comment){
        $sql = 'select * from comments where commentID = ' . $comment . ' and userID = ' . $author;
        if (sizeof(Database::getData($sql)) > 0)
            return true;
        else
            return false;

    }

}