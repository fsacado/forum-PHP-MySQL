<?php

namespace Loann\Model;

use Loann\Model\Manager;

class MessageManager extends Manager
{
    const TABLE = 'Message';
    const CLASSREF = Message::class;

    public function findMessageNumberPerCategory($category_name)
    {
        $req = "SELECT COUNT(*) FROM " . self::TABLE . "
                INNER JOIN Topic ON Topic.id = " . self::TABLE . ".topic_id 
                INNER JOIN Subclass ON Topic.subclass_id=Subclass.id 
                INNER JOIN Category ON Subclass.category_id=Category.id 
                WHERE Category.name=:name";

        $statement = $this->pdo->prepare($req);
        $statement->bindParam(':name', $category_name);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_COLUMN, 0); // returns only the count value
    }

    public function findMessageNumberPerTopic($topic_title)
    {
        $req =  "SELECT COUNT(*) AS message_number FROM Message 
                WHERE topic_id=(
                    SELECT id FROM Topic WHERE title=:title
                )";

        $statement = $this->pdo->prepare($req);
        $statement->bindParam(':title', $topic_title);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_COLUMN, 0);
    }

    public function findDateAuthorLastAddedMessagePerCategory($category_name)
    {
        $req = "SELECT " . self::TABLE . ".publication_date, User.username FROM " . self::TABLE . "
                INNER JOIN Topic ON Topic.id=" . self::TABLE . ".topic_id 
                INNER JOIN Subclass ON Subclass.id=Topic.subclass_id 
                INNER JOIN Category ON Category.id=Subclass.category_id 
                INNER JOIN User ON User.id=" . self::TABLE . ".author_id
                WHERE Category.name=:name 
                ORDER BY " . self::TABLE . ".publication_date DESC 
                LIMIT 1";
        
        $statement = $this->pdo->prepare($req);
        $statement->bindParam(':name', $category_name);
        $statement->execute();
    
        return $statement->fetch(\PDO::FETCH_ASSOC);

    }

    public function findDateAuthorLastAddedMessagePerTopic($topic_title)
    {
        $req = "SELECT " . self::TABLE . ".publication_date, User.username FROM " . self::TABLE . "
                INNER JOIN Topic ON " . self::TABLE . ".topic_id=Topic.id 
                INNER JOIN User ON " . self::TABLE . ".author_id=User.id 
                WHERE Topic.title=:title 
                ORDER BY " . self::TABLE . ".publication_date DESC
                LIMIT 1";

        $statement = $this->pdo->prepare($req);
        $statement->bindParam(':title', $topic_title);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
