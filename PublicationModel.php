<?php
require_once "Database/Database.php";
require_once "CommentModel.php";
require_once "CategoryModel.php";

class PublicationModel
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $category;
    private $date;
    private $image;
    private $commented;
    private $liked;
    private $comments;

    public function __construct($id, $title, $content, $author, $date, $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->date = $date;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getCommented()
    {
        return $this->commented;
    }

    /**
     * @param mixed $commented
     */
    public function setCommented($commented)
    {
        $this->commented = $commented;
    }

    /**
     * @return mixed
     */
    public function getLiked()
    {
        return $this->liked;
    }

    /**
     * @param mixed $liked
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    public static function getLatestPublications($start, $count)
    {
        $sql = "select * from publications p inner join categories c on p.categoryID = c.categoryID inner join users u on p.userID = u.userID order by p.date_ desc limit " . $start . ", " . $count;
        $publications  = Database::getData($sql);
        for ($i = 0; $i < sizeof($publications); ++$i)
        {
            $publications[$i]['commented'] = CommentModel::getCommentCount($publications[$i]['publicationID']);
        }
        return $publications;
    }

    public static function getHotPublications($start, $count)
    {
        $sql = "select * from publications p inner join categories c on p.categoryID = c.categoryID inner join users u on p.userID = u.userID order by p.liked desc limit " . $start . ", " . $count;
        $publications  = Database::getData($sql);
        for ($i = 0; $i < sizeof($publications); ++$i)
        {
            $publications[$i]['commented'] = CommentModel::getCommentCount($publications[$i]['publicationID']);
        }
        return $publications;
    }

    public static function getDiscussedPublications($start, $count)
    {
        $sql = "select * from publications p inner join categories c on p.categoryID = c.categoryID inner join users u on p.userID = u.userID order by p.commented desc limit " . $start . ", " . $count;
        $publications  = Database::getData($sql);
        for ($i = 0; $i < sizeof($publications); ++$i)
        {
            $publications[$i]['commented'] = CommentModel::getCommentCount($publications[$i]['publicationID']);
        }
        return $publications;
    }

    public static function getPublicationsByCategory($start, $count, $categoryID)
    {
        $sql = "select * from publications p inner join categories c on p.categoryID = c.categoryID inner join users u on p.userID = u.userID where p.categoryID = ".$categoryID." limit " . $start . ", " . $count . " ";
        $publications  = Database::getData($sql);
        for ($i = 0; $i < sizeof($publications); ++$i)
        {
            $publications[$i]['commented'] = CommentModel::getCommentCount($publications[$i]['publicationID']);
        }
        return $publications;
    }

    public static function getPublicationsCount()
    {
        $sql = 'select COUNT(publicationID) AS total from publications';
        return Database::getData($sql)[0]['total'];
    }

    public static function getPublicationsCountByCategory($categoryID)
    {
        $sql = 'select COUNT(publicationID) AS total from publications where categoryID = ' . $categoryID;
        return Database::getData($sql)[0]['total'];
    }

    public static function getAuthorPublications($start, $count, $id)
    {
        $sql = "select * from publications p inner join categories c on p.categoryID = c.categoryID inner join users u on p.userID = u.userID where p.userID = ".$id." limit " . $start . ", " . $count . " ";
        $publications  = Database::getData($sql);
        for ($i = 0; $i < sizeof($publications); ++$i)
        {
            $publications[$i]['commented'] = CommentModel::getCommentCount($publications[$i]['publicationID']);
        }
        return $publications;
    }

    public static function getAuthorPublicationsCount($id)
    {
        $sql = 'select COUNT(publicationID) AS total from publications where userID = ' . $id;
        return Database::getData($sql)[0]['total'];
    }

    public static function publish($author, $title, $content, $category, $image)
    {
        $sql = 'insert into publications (userID, title, content, categoryID, image) values ('.$author.', "'.$title.'", "'.$content.'", '.$category.', "'.$image.'")';
        $conn = Database::connection();
        if ($conn->query($sql)){
            return $conn->insert_id;
        }
        return null;
    }

    public static function update($publicationID, $title, $content, $image)
    {
        $sql = 'update publications set title = "'.$title.'", content = "'.$content.'", image = "'.$image.'" where publicationID = ' . $publicationID;
        if (Database::executeData($sql)){
            return 1;
        }
        return null;
    }

    public static function deletePublication($publicationID){
        $sql = 'delete from publications where publicationID = ' . $publicationID;
        if (Database::executeData($sql)){
            return 1;
        }
        return null;
    }

    public static function isMyPublication($author, $publicationID){
        $sql = 'select * from publications where publicationID = ' . $publicationID . ' and userID = ' . $author;
        if (sizeof(Database::getData($sql)) > 0)
            return true;
        else
            return false;
    }

    public static function getPublication($publicationID)
    {
        $sql = "select * from publications p inner join categories c on p.categoryID = c.categoryID inner join users u on p.userID = u.userID where p.publicationID = " . $publicationID;
        $publication = Database::getData($sql)[0];
        $publication['commented'] = CommentModel::getCommentCount($publicationID);
        $publication['comments'] = CommentModel::getComments($publicationID);
        return $publication;
    }

    public static function isLiked($publicationID, $userID)
    {
        $sql = 'select * from likedPublications where userID = ' . $userID . ' and publicationID = ' . $publicationID;
        if (sizeof(Database::getData($sql)) > 0)
            return true;
        else
            return false;
    }

    public static function like($publicationID, $userID)
    {
        $sql = 'insert into likedPublications (userID, publicationID) values ('.$userID.', '.$publicationID.')';
        if (Database::executeData($sql)){
            $sql2 = 'update publications set liked = liked + 1 where publicationID = ' . $publicationID;
            if (Database::executeData($sql2)){
                return 1;
            }else{
                return null;
            }
        }
        return null;
    }

    public static function unlike($publicationID, $userID)
    {
        $sql = 'delete from likedPublications where publicationID = '.$publicationID.' and userID = '.$userID;
        if (Database::executeData($sql)){
            $sql2 = 'update publications set liked = liked - 1 where publicationID = ' . $publicationID;
            if (Database::executeData($sql2)){
                return 1;
            }else{
                return null;
            }
        }
        return null;
    }

}