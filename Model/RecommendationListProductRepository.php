<?php
declare(strict_types=1);

namespace SwiftOtter\FriendRecommendations\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductInterface;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductInterfaceFactory;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductSearchResultsInterface;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListProductSearchResultsInterfaceFactory;
use SwiftOtter\FriendRecommendations\Api\RecommendationListProductRepositoryInterface;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationListProduct as RecommendationListProductResource;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationListProduct\Collection as RecommendationListProductCollection;
use SwiftOtter\FriendRecommendations\Model\ResourceModel\RecommendationListProduct\CollectionFactory as RecommendationListProductCollectionFactory;

class RecommendationListProductRepository implements RecommendationListProductRepositoryInterface
{
    private RecommendationListProductResource $listProductResource;
    private RecommendationListProductInterfaceFactory $listProductFactory;
    private RecommendationListProductCollectionFactory $listProductCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private RecommendationListProductSearchResultsInterfaceFactory $listProductSearchResultsFactory;

    public function __construct(
        RecommendationListProductResource $listProductResource,
        RecommendationListProductInterfaceFactory $listProductFactory,
        RecommendationListProductCollectionFactory $listProductCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RecommendationListProductSearchResultsInterfaceFactory $listProductSearchResultsFactory
    ) {
        $this->listProductResource = $listProductResource;
        $this->listProductFactory = $listProductFactory;
        $this->listProductCollectionFactory = $listProductCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->listProductSearchResultsFactory = $listProductSearchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): RecommendationListProductInterface
    {
        /** @var RecommendationListProductInterface $listProduct */
        $listProduct = $this->listProductFactory->create();
        $this->listProductResource->load($listProduct, $id);
        if (!$listProduct->getId()) {
            throw new NoSuchEntityException(__('Recommendation list product not found'));
        }
        return $listProduct;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): RecommendationListProductSearchResultsInterface
    {
        /** @var RecommendationListProductCollection $lists */
        $listProducts = $this->listProductCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $listProducts);

        /** @var RecommendationListProductSearchResultsInterface $results */
        $results = $this->listProductSearchResultsFactory->create();
        $results->setSearchCriteria($searchCriteria);
        $results->setItems($listProducts->getItems());
        $results->setTotalCount($listProducts->getSize());
        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function save(RecommendationListProductInterface $listProduct): RecommendationListProductInterface
    {
        try {
            $this->listProductResource->save($listProduct);
            $savedListProduct = $this->getById($listProduct->getId());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $savedListProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RecommendationListProductInterface $listProduct): bool
    {
        try {
            $this->listProductResource->delete($listProduct);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
}
