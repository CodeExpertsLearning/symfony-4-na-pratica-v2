<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
	/**
	 * @Route("/")
	 */
	public function index()
	{
		$posts = [
			[
				'id' => 1,
				'title' => 'Post 1',
				'created_at' => '2019-01-28 19:51:02'
			],
			[
				'id' => 2,
				'title' => 'Post 2',
				'created_at' => '2019-01-28 19:51:02'
			],[
				'id' => 3,
				'title' => 'Post 3',
				'created_at' => '2019-01-28 19:51:02'
			]
		];

		return $this->render('index.html.twig', [
			'title' => 'Postagem Teste',
			'posts' => $posts
		]);
	}

	/**
	 * @Route("/post-exemplo/{slug}")
	 */
	public function single($slug)
	{

		return $this->render('single.html.twig',
			[
				'slug' => $slug
			]);
	}
}