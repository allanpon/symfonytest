<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post.')]

class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        // Créer un nouveau Post avec un titre
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        $form->getErrors();

        if($form->isSubmitted() && $form->isValid()) {
            // Manager d'entités
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('post.index'));
        }

        // Message flash si la création a été réussi
        $this->addFlash('reussi', 'Le post a bien été créé.');

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Post $post) {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Post $post) {
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('reussi', 'Le post a bien été supprimé.');

        return $this->redirect($this->generateUrl('post.index'));
    }
}
