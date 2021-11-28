<?php

namespace App\Controller;

use App\Entity\UserScore;
use App\Repository\UserScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'api_post_index', methods:["GET"])]
    public function index(UserScoreRepository $userscoreRepository): Response
    {
        return $this->json($userscoreRepository->findAll(), 200, [], ['groups' => 'username:score']);
    }

    #[Route('/api/post', name: 'api_post_store', methods:["POST"])]
    public function store(Request $resquest, SerializerInterface $serializer, EntityManagerInterface $em){
        $jsonRecu = $resquest->getContent();
        $user = $serializer->deserialize($jsonRecu, UserScore::class, 'json');

        $em->persist($user);
        $em->flush();
        
        return $this->json($user, 201, [], ['groups' => 'username:score']);
    }
}
