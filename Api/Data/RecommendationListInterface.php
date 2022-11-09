<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\FriendRecommendations\Api\Data;

interface RecommendationListInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $value
     * @return RecommendationListInterface
     */
    public function setId($value);

    public function getEmail(): string;

    public function setEmail(string $email): RecommendationListInterface;

    public function getFriendName(): string;

    public function setFriendName(string $name): RecommendationListInterface;

    public function getTitle(): ?string;

    public function setTitle(string $title): RecommendationListInterface;

    public function getNote(): ?string;

    public function setNote(string $note): RecommendationListInterface;
}
