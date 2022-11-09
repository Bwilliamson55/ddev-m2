<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api\SearchCriteria\ProductCollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Framework\Exception\InputException;

class RecommendationListIdsFilter implements CustomFilterInterface
{
    /**
     * {@inheritdoc}
     * @throws InputException
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        $value = $filter->getValue();
        $cond = $filter->getConditionType();

        if ($cond != 'eq' && $cond != 'in') {
            throw new InputException(__('Invalid filter type %1', $cond));
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        $this->joinRecommendationLists($collection);

        $collection->getSelect()->where('recommendation_products.list_id IN (?)', $value);
        return true;
    }

    private function joinRecommendationLists(AbstractDb $collection): void
    {
        if ($collection->getFlag('recommendation_lists_joined')) {
            return;
        }

        $collection->getSelect()->join(
            ['recommendation_products' => $collection->getConnection()->getTableName('friend_recommendations_product')],
            ProductCollection::MAIN_TABLE_ALIAS . '.sku = recommendation_products.sku',
            []
        );

        $collection->setFlag('recommendation_lists_joined', true);
    }
}
