<?php
declare(strict_types=1);

namespace SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationListProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\FriendRecommendations\Model\RecommendationListProduct;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationListProduct as RecommendationListProductResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(RecommendationListProduct::class, RecommendationListProductResource::class);
    }
}
