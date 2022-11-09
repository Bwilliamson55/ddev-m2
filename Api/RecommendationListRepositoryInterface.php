<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListInterface;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListSearchResultsInterface;

interface RecommendationListRepositoryInterface
{
    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): RecommendationListInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): RecommendationListSearchResultsInterface;

    /**
     * @throws CouldNotSaveException
     */
    public function save(RecommendationListInterface $policy): RecommendationListInterface;

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(RecommendationListInterface $policy): bool;
}
