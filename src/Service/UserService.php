<?php

namespace App\Service;

use App\Dto\User\UserDetailsOutput;
use App\Dto\User\UserProfilePictureInput;
use App\Dto\User\UserRegisterInput;
use App\Entity\Enum\DocumentType;
use App\Entity\User;
use App\Exception\User\EmailAlreadyUsedException;
use App\Repository\UserRepository;
use App\Service\Utils\AuditService;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly AuditService $audit,
        private readonly LoggerInterface $domainLogger,
        private readonly DocumentService $documentService,
    ) {
    }

    /**
     * Registers a new account from the submitted payload.
     *
     * @throws EmailAlreadyUsedException when an account already uses this email
     */
    public function register(UserRegisterInput $input): User
    {
        if (null !== $this->userRepository->findOneByEmail($input->email)) {
            // aucune donnée personnelle ici : ni l'adresse refusée, ni le corps reçu
            $this->domainLogger->warning('registration conflict');

            throw new EmailAlreadyUsedException();
        }

        $user = new User();
        $user->setEmail($input->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $input->password));
        $user->setFirstName($input->firstName);
        $user->setLastName($input->lastName);

        $this->audit->stampCreation($user);

        $this->userRepository->persist($user);
        $this->userRepository->flush();

        $this->domainLogger->info('user registered', ['id' => (string) $user->getId()]);

        return $user;
    }

    /**
     * Stores a new profile picture for this user and soft-deletes the previous one,
     * in a single write.
     */
    public function changeProfilePicture(User $user, UserProfilePictureInput $input): void
    {
        // ranger un document appartient au domaine des documents : ce service passe par le sien
        $document = $this->documentService->store($input->file, DocumentType::ProfilePicture);

        $previous = $user->getProfilePicture();

        // l'ancienne photo n'est pas effacée : son document est marqué, son fichier reste
        if (null !== $previous) {
            $this->documentService->softDelete($previous);
        }

        $user->setProfilePicture($document);

        // un seul flush : le nouveau document, l'ancien marqué et l'utilisateur s'écrivent ensemble
        $this->userRepository->flush();
    }

    /**
     * Turns an account into the payload of its detailed representation.
     */
    public function toDetails(User $user): UserDetailsOutput
    {
        $picture = $user->getProfilePicture();

        return new UserDetailsOutput(
            id: (string) $user->getId(),
            email: $user->getEmail(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            createdAt: $user->getCreatedAt(),
            // une adresse fraîche à chaque lecture : elle expire, le client rappelle /users/me
            profilePictureUrl: null === $picture ? null : $this->documentService->toSignedUrl($picture),
        );
    }
}
