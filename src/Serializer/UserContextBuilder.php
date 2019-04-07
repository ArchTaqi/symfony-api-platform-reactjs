<?php


namespace App\Serializer;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Core\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

/**
 * Class UserContextBuilder
 * @package App\Serializer
 */
class UserContextBuilder implements SerializerContextBuilderInterface
{
    /**
     * @var SerializerContextBuilderInterface
     */
    private $decorated;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    public function __construct(
        SerializerContextBuilderInterface $decorated,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }
    /**
     * Creates a serialization context from a Request.
     * @param Request $request
     * @param bool $normalization
     * @param array|null $extractedAttributes
     * @throws RuntimeException
     * @return array
     */
    public function createFromRequest(
        Request $request,
        bool $normalization,
        array $extractedAttributes = null
    ): array {
        $context = $this->decorated->createFromRequest(
            $request, $normalization, $extractedAttributes
        );
        // Class being serialized/deserialized
        $resourceClass = $context['resource_class'] ?? null; // Default to null if not set
        if (
            User::class === $resourceClass &&
            isset($context['groups']) &&
            $normalization === true &&
            $this->authorizationChecker->isGranted(User::ROLE_ADMIN)
        ) {
            $context['groups'][] = 'admin:read';
        }
        return $context;
    }
}