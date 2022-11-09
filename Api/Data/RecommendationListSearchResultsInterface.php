<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RecommendationListSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return RecommendationListInterface[]
     */
    public function getItems();

    /**
     * @param RecommendationListInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
