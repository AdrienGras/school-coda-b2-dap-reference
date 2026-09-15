<?php

namespace App\Dto\Cart;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\Enum\CartStatus;
use Symfony\Component\Uid\Uuid;

final class CartDetailsOutput
{
    /**
     * @param CartLineOutput[] $items
     */
    public function __construct(
        #[ApiProperty(description: "Identifiant du panier.")]
        public readonly Uuid $id,
        #[ApiProperty(description: "État du panier.")]
        public readonly CartStatus $status,
        #[ApiProperty(description: "Les lignes du panier.")]
        public readonly array $items,
        #[ApiProperty(description: "Somme des sous-totaux des lignes, en centimes.")]
        public readonly int $total,
        #[ApiProperty(description: "Date d'ouverture du panier.")]
        public readonly \DateTimeImmutable $createdAt,
    ) {
    }
}
