<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
	public function index()
	{
		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

		return $this->render('category/index.html.twig', [
			'categories' => $categories
		]);
	}

	/**
	 * @Route("/create", name="create")
	 */
	public function create(Request $request)
	{
		$category = new Category();

		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$category = $form->getData();

			$manager = $this->getDoctrine()->getManager();
			$manager->persist($category);
			$manager->flush();

			$this->addFlash('success', 'Categoria criada com sucesso!');
			return $this->redirectToRoute('category_index');
		}

		return $this->render('category/create.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/edit/{id}", name="edit")
	 */
	public function edit(Request $request, $id)
	{
		$category = $this->getDoctrine()
		                 ->getRepository(Category::class)
		                 ->find($id);

		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$category = $form->getData();

			$manager = $this->getDoctrine()->getManager();
			$manager->flush();

			$this->addFlash('success', 'Categoria atualizada com sucesso!');
			return $this->redirectToRoute('category_index');
		}

		return $this->render('category/edit.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/remove/{id}", name="remove")
	 */
	public function remove($id)
	{
		$category = $this->getDoctrine()->getRepository(Category::class)->find($id);

		$manager = $this->getDoctrine()->getManager();
		$manager->remove($category);
		$manager->flush();

		$this->addFlash('success', 'Categoria removida com sucesso');
		return $this->redirectToRoute('category_index');
	}
}
