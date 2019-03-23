<?php
/**
 * Created by PhpStorm.
 * User: muhammadtaqi
 * Date: 3/22/19
 * Time: 10:16 PM
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Post;

/**
 * Class PostController
 * @package App\Controller
 * @Route("/posts")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $items = $repository->findAll();
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (Post $item) {
                    return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
                }, $items)
            ]
        );
    }
    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @ParamConverter("post", class="App:Post")
     */
    public function post($post)
    {
        // It's the same as doing find($id) on repository
        return $this->json($post);
    }
    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     * The below annotation is not required when $post is typehinted with Post
     * and route parameter name matches any field on the Post entity
     * @ParamConverter("post", class="App:Post", options={"mapping": {"slug": "slug"}})
     */
    public function postBySlug(Post $post)
    {
        // Same as doing findOneBy(['slug' => contents of {slug}])
        return $this->json($post);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');
        $post = $serializer->deserialize($request->getContent(), Post::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->json($post);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     * @Route("/post/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}