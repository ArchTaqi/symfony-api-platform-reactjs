<?php
/**
 * Created by PhpStorm.
 * User: muhammadtaqi
 * Date: 3/24/19
 * Time: 11:23 AM
 */

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @var \Faker\Factory
     */
    private $faker;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    private const USERS = [
        [
            'email' => 'taqi.official@gmail.com',
            'name' => 'Muhammad Taqi',
            'password' => 'secret123#',
            'roles' => [User::ROLE_SUPERADMIN],
        ],
        [
            'email' => 'turab.official@gmail.com',
            'name' => 'Muhammad Turab',
            'password' => 'secret123#',
            'roles' => [User::ROLE_ADMIN]
        ],
        [
            'email' => 'ali.salman@gmail.com',
            'name' => 'Ali Salman',
            'password' => 'secret123#',
            'roles' => [User::ROLE_WRITER]
        ],
        [
            'email' => 'meesum@gmail.com',
            'name' => 'Mesum Naqvi',
            'password' => 'secret123#',
            'roles' => [User::ROLE_WRITER]
        ],
    ];

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }
    public function loadBlogPosts(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $blogPost = new Post();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->boolean);
            $blogPost->setContent($this->faker->realText());
            $authorReference = $this->getRandomUserReference($blogPost);
            $blogPost->setAuthor($authorReference);
            $blogPost->setSlug($this->faker->slug);
            $this->setReference("post_$i", $blogPost);
            $manager->persist($blogPost);
        }
        $manager->flush();
    }
    public function loadComments(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            for ($j = 0; $j < rand(1, 10); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);
                $authorReference = $this->getRandomUserReference($comment);
                $comment->setAuthor($authorReference);
                $comment->setPost($this->getReference("post_$i"));
                $manager->persist($comment);
            }
        }
        $manager->flush();
    }
    public function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userFixture) {
            $user = new User();
//            $user->setUsername($userFixture['username']);
            $user->setEmail($userFixture['email']);
            $user->setName($userFixture['name']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $userFixture['password']
                )
            );
            $user->setRoles($userFixture['roles']);
            $this->addReference('user_'.$userFixture['email'], $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
    protected function getRandomUserReference($entity): User
    {
        $randomUser = self::USERS[rand(0, 3)];
        if ($entity instanceof Post && !count(
                array_intersect(
                    $randomUser['roles'],
                    [User::ROLE_SUPERADMIN, User::ROLE_ADMIN, User::ROLE_WRITER]
                )
            )) {
            return $this->getRandomUserReference($entity);
        }
        if ($entity instanceof Comment && !count(
                array_intersect(
                    $randomUser['roles'],
                    [
                        User::ROLE_SUPERADMIN,
                        User::ROLE_ADMIN,
                        User::ROLE_WRITER,
                        User::ROLE_COMMENTATOR,
                    ]
                )
            )) {
            return $this->getRandomUserReference($entity);
        }
        return $this->getReference(
            'user_'.$randomUser['email']
        );
    }
}