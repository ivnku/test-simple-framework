<?php

namespace TestFramework\App\Models;

use TestFramework\Core\Model;
use PDO;

class Post extends Model
{
    public static function getAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC');

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}