<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductInterface;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductSearchResultsInterface;

interface RecommendationListProductRepositoryInterface
{
    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): RecommendationListProductInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): RecommendationListProductSearchResultsInterface;

    /**
     * @throws CouldNotSaveException
     */
    public function save(RecommendationListProductInterface $listProduct): RecommendationListProductInterface;

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(RecommendationListProductInterface $listProduct): bool;
}
