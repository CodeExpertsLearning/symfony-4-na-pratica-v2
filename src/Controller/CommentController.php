<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment", name="comment_")
 */
class CommentController extends AbstractController
{
	/**
     * @Route("/save/{post_id}", name="save")
     */
    public function save(Request $request, $post_id)
    {
        $form = $this->createForm(CommentType::class, new Comment());
        $form->handleRequest($request);

        if($form->isSubmitted()) {
	        $doctrine = $this->getDoctrine();
	        $post = $doctrine->getRepository(Post::class)->find($post_id);

	        $comment = $form->getData();
			$comment->setPost($post);

			$manager = $doctrine->getManager();
	        $manager->persist($comment);
	        $manager->flush();

	        return $this->redirectToRoute('single_post', ['slug' => $post->getSlug()]);
        }

	    return $this->redirectToRoute('home');
    }
}
