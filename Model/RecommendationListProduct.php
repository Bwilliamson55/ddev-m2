<?php
declare(strict_types=1);

namespace SwiftOtter\FriendRecommendations\Model;

use Magento\Framework\Model\AbstractModel;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductInterface;

class RecommendationListProduct extends AbstractModel implements RecommendationListProductInterface
{
    public function getListId(): int
    {
        return (int) $this->_getData('list_id');
    }

    public function setListId(int $id): RecommendationListProductInterface
    {
        return $this->setData('list_id', $id);
    }

    public function getSku(): string
    {
        return (string) $this->_getData('sku');
    }

    public function setSku(string $sku): RecommendationListProductInterface
    {
        return $this->setData('sku', $sku);
    }
}
