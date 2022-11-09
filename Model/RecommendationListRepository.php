<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListInterface;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListSearchResultsInterface;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListSearchResultsInterfaceFactory;
use SwiftOtter\FriendRecommendations\Api\RecommendationListRepositoryInterface;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationList as RecommendationListResource;
use SwiftOtter\FriendRecommendations\Model\RecommendationListFactory;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationList\Collection as RecommendationListCollection;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationList\CollectionFactory as RecommendationListCollectionFactory;

class RecommendationListRepository implements RecommendationListRepositoryInterface
{
    private RecommendationListResource $listResource;
    private RecommendationListFactory $listFactory;
    private RecommendationListCollectionFactory $listCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private RecommendationListSearchResultsInterfaceFactory $listSearchResultsFactory;

    public function __construct(
        RecommendationListResource $listResource,
        RecommendationListFactory $listFactory,
        RecommendationListCollectionFactory $listCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RecommendationListSearchResultsInterfaceFactory $listSearchResultsFactory
    ) {
        $this->listResource = $listResource;
        $this->listFactory = $listFactory;
        $this->listCollectionFactory = $listCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->listSearchResultsFactory = $listSearchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): RecommendationListInterface
    {
        /** @var RecommendationListInterface $list */
        $list = $this->listFactory->create();
        $this->listResource->load($list, $id);

        if (!$list->getId()) {
            throw new NoSuchEntityException(__('No recommendation list found'));
        }

        return $list;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): RecommendationListSearchResultsInterface
    {
        /** @var RecommendationListCollection $lists */
        $lists = $this->listCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $lists);

        /** @var RecommendationListSearchResultsInterface $results */
        $results = $this->listSearchResultsFactory->create();
        $results->setSearchCriteria($searchCriteria);
        $results->setItems($lists->getItems());
        $results->setTotalCount($lists->getSize());
        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function save(RecommendationListInterface $list): RecommendationListInterface
    {
        try {
            $this->listResource->save($list);
            $savedList = $this->getById((int)$list->getId());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $savedList;
    }

    public function delete(RecommendationListInterface $list): bool
    {
        try {
            $this->listResource->delete($list);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
}
