<?php
declare(strict_types=1);

namespace SwiftOtter\FriendRecommendations\Model;

use Magento\Framework\Model\AbstractModel;
use SwiftOtter\FriendRecommendations\Api\Data\RecommendationListInterface;

class RecommendationList extends AbstractModel implements RecommendationListInterface
{
    public function getEmail(): string
    {
        return (string) $this->_getData('email');
    }

    public function setEmail(string $email): RecommendationListInterface
    {
        return $this->setData('email', $email);
    }

    public function getFriendName(): string
    {
        return (string) $this->_getData('friend_name');
    }

    public function setFriendName(string $name): RecommendationListInterface
    {
        return $this->setData('friend_name', $name);
    }

    public function getTitle(): ?string
    {
        $value = $this->_getData('title');
        return ($value !== null) ? (string) $value : null;
    }

    public function setTitle(string $title): RecommendationListInterface
    {
        return $this->setData('title', $title);
    }

    public function getNote(): ?string
    {
        $value = $this->_getData('note');
        return ($value !== null) ? (string) $value : null;
    }

    public function setNote(string $note): RecommendationListInterface
    {
        return $this->setData('note', $note);
    }
}
