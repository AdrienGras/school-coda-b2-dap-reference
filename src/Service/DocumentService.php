<?php

namespace App\Service;

use App\Entity\Document;
use App\Entity\Enum\DocumentType;
use App\Exception\Document\DocumentNotFoundException;
use App\Repository\DocumentRepository;
use App\Service\Utils\AuditService;
use App\Service\Utils\DocumentStorageResolver;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class DocumentService
{
    public function __construct(
        private readonly DocumentRepository $documentRepository,
        private readonly DocumentStorageResolver $storageResolver,
        private readonly AuditService $audit,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly UrlSignerInterface $urlSigner,
    ) {
    }

    /**
     * Writes the uploaded file to the storage of its type, and builds its document,
     * persisted but not flushed.
     */
    public function store(UploadedFile $file, DocumentType $type): Document
    {
        // le type lu dans les octets, jamais celui que le client a déclaré
        $mimeType = $file->getMimeType();
        $extension = MimeTypes::getDefault()->getExtensions($mimeType)[0];

        $document = new Document();
        $document->setType($type);
        // le nom sur le support ne doit rien au client : unique, ASCII, extension du type reconnu
        $document->setStorageKey(sprintf('%s.%s', $document->getId(), $extension));
        // le nom d'origine vient du client, sans limite : on le tronque à la taille de la colonne
        $document->setOriginalName(mb_substr($file->getClientOriginalName(), 0, 255));
        $document->setMimeType($mimeType);
        $document->setSize($file->getSize());

        // le fichier d'abord, la base ensuite : un échec du flush laisse au pire un orphelin
        $stream = fopen($file->getPathname(), 'r');
        $this->storageResolver->resolve($type)->writeStream($document->getStorageKey(), $stream);
        fclose($stream);

        $this->audit->stampCreation($document);

        // aucun flush : c'est l'appelant qui écrit, en une seule fois
        $this->documentRepository->persist($document);

        return $document;
    }

    /**
     * Marks this document as deleted. Its file stays on the storage.
     */
    public function softDelete(Document $document): void
    {
        $this->audit->markDeleted($document);
    }

    /**
     * Returns the document carrying this identifier.
     *
     * @throws DocumentNotFoundException when no live document carries this identifier
     */
    public function findOneById(Uuid $id): Document
    {
        // le filtre de suppression douce s'applique au find() : un document remplacé n'est pas trouvé
        $document = $this->documentRepository->find($id);

        if (null === $document) {
            throw new DocumentNotFoundException();
        }

        return $document;
    }

    /**
     * Opens a read stream on the stored file of this document.
     *
     * @return resource
     *
     * @throws DocumentNotFoundException when the file is missing from its storage
     */
    public function openStream(Document $document)
    {
        $storage = $this->storageResolver->resolve($document->getType());

        // une ligne en base dont le fichier a disparu n'a rien à rendre : 404, et non le 500 de
        // readStream()
        if (!$storage->fileExists($document->getStorageKey())) {
            throw new DocumentNotFoundException();
        }

        return $storage->readStream($document->getStorageKey());
    }

    /**
     * Builds the absolute, signed and expiring download URL of this document.
     */
    public function toSignedUrl(Document $document): string
    {
        // absolue : le client la pose telle quelle dans un src, sans savoir où l'API est hébergée
        $url = $this->urlGenerator->generate(
            'document_download',
            ['id' => $document->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        // aucune date passée : le signataire ajoute la durée configurée à l'heure de la signature
        return $this->urlSigner->sign($url);
    }
}
