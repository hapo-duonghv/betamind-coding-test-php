<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * LikeBehavior behavior
 */
class LikeBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function like($userId, $articleId, $createdAt)
    {
        $likesTable = TableRegistry::getTableLocator()->get('ArticleLikes');
        $like = $likesTable->newEntity([
            'user_id' => $userId,
            'article_id' => $articleId,
            'created_at' => $createdAt
        ]);
        return $likesTable->save($like);
    }

    public function checkIfUserHasLikedArticle($userId, $articleId)
    {
        $likesTable = TableRegistry::getTableLocator()->get('ArticleLikes');

        // Check if a like record exists for the user and article
        $like = $likesTable->find()
            ->where(['user_id' => $userId, 'article_id' => $articleId])
            ->first();

        return $like !== null;
    }
}
