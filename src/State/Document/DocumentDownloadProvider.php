<?php

namespace App\State\Document;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\DocumentService;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @implements ProviderInterface<StreamedResponse>
 */
final class DocumentDownloadProvider implements ProviderInterface
{
    public function __construct(
        private readonly DocumentService $documentService,
    ) {
    }

    /**
     * Streams the stored file of the document carried by the URL.
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): StreamedResponse
    {
        // si on arrive ici, le bundle a déjà vérifié la signature et l'expiration
        $document = $this->documentService->findOneById($uriVariables['id']);
        $stream = $this->documentService->openStream($document);

        // le fichier part par morceaux, sans passer en entier par la mémoire
        $response = new StreamedResponse(static function () use ($stream): void {
            fpassthru($stream);
            fclose($stream);
        });

        $response->headers->set('Content-Type', $document->getMimeType());
        // le repli ASCII est obligatoire : sans lui, un nom accentué lève une exception, donc un 500
        $response->headers->set('Content-Disposition', HeaderUtils::makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $document->getOriginalName(),
            $document->getStorageKey(),
        ));
        $response->headers->set('Cache-Control', 'private, max-age=900');

        return $response;
    }
}
