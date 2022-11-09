<?php
declare(strict_types=1);

namespace SwiftOtter\FriendRecommendations\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RecommendationListProduct extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('friend_recommendations_product', 'id');
    }
}
