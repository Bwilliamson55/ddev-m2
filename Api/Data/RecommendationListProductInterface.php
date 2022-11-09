<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api\Data;

interface RecommendationListProductInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $value
     * @return RecommendationListProductInterface
     */
    public function setId($value);

    public function getListId(): int;

    public function setListId(int $id): RecommendationListProductInterface;

    public function getSku(): string;

    public function setSku(string $sku): RecommendationListProductInterface;
}
