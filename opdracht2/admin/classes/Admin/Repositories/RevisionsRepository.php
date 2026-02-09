<?php
declare(strict_types=1);

namespace Admin\Repositories;

use Admin\Core\Database;
use PDO;

final class RevisionsRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function create(array $data): void
    {
        $sql = "INSERT INTO post_revisions 
                (post_id, user_id, title, content, slug, featured_media_id, created_at) 
                VALUES 
                (:post_id, :user_id, :title, :content, :slug, :featured_media_id, NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'post_id'           => $data['post_id'],
            'user_id'           => $data['user_id'],
            'title'             => $data['title'],
            'content'           => $data['content'],
            'slug'              => $data['slug'],
            'featured_media_id' => $data['featured_media_id'] ?: null,
        ]);
    }

    public function getAllByPostId(int $postId): array
    {
        $sql = "SELECT r.*, u.name AS user_name
                FROM post_revisions r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.post_id = :post_id
                ORDER BY r.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['post_id' => $postId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT r.*, u.name AS user_name
                FROM post_revisions r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row !== false ? $row : null;
    }

    public function pruneRevisions(int $postId, int $max = 3): void
    {
        $sql = "SELECT id FROM post_revisions
                WHERE post_id = :post_id
                ORDER BY created_at DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('post_id', $postId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $max, PDO::PARAM_INT);
        $stmt->execute();

        $keepIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($keepIds)) {
            return;
        }

        $placeholders = implode(',', array_fill(0, count($keepIds), '?'));
        $deleteSql = "DELETE FROM post_revisions
                      WHERE post_id = ?
                      AND id NOT IN ($placeholders)";

        $params = array_merge([$postId], $keepIds);
        $stmt = $this->pdo->prepare($deleteSql);
        $stmt->execute($params);
    }

    /**
     * Overzicht: alle revisies met gekoppelde post- en user-info.
     */
    public function getAllWithPost(): array
    {
        $sql = "SELECT r.*, 
                       p.title AS post_title, 
                       p.slug AS post_slug,
                       u.name AS user_name
                FROM post_revisions r
                INNER JOIN posts p ON r.post_id = p.id
                LEFT JOIN users u ON r.user_id = u.id
                ORDER BY r.created_at DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}


