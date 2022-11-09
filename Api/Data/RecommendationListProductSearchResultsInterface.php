<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RecommendationListProductSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return RecommendationListProductInterface[]
     */
    public function getItems();

    /**
     * @param RecommendationListProductInterface[] $items
     */
    public function setItems(array $items);
}
