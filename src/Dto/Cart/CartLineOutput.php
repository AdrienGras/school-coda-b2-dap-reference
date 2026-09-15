<?php

namespace App\Dto\Cart;

use ApiPlatform\Metadata\ApiProperty;
use App\Dto\Trip\TripListOutput;
use Symfony\Component\Uid\Uuid;

final class CartLineOutput
{
    public function __construct(
        #[ApiProperty(description: "Identifiant de la ligne.")]
        public readonly Uuid $id,
        #[ApiProperty(description: "Le lancer réservé.")]
        public readonly TripListOutput $trip,
        #[ApiProperty(description: "Nombre de places.")]
        public readonly int $passengers,
        #[ApiProperty(description: "Prix du lancer multiplié par le nombre de places, en centimes.")]
        public readonly int $subtotal,
    ) {
    }
}
