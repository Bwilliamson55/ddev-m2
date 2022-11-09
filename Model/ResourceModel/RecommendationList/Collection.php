<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationList;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\FriendRecommendations\Model\RecommendationList;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationList as RecommendationListResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(RecommendationList::class, RecommendationListResource::class);
    }
}
