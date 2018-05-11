<?php

namespace AppBundle\Controller;


use AppBundle\Entity\RedditPost;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class RedditController extends Controller
{

	/**
     * @Route("/", name="homepage")
     */
	public function listAction() 
	{
		$posts = $this->getDoctrine()->getRepository('AppBundle:RedditPost')->findAll();

		return $this->render('reddit/index.html.twig', [
			'posts' => $posts,
		]);

	}

	/**
	* @Route("/create/{text}", name="create")
	*/
	public function createAction($text)
	{
		$em = $this->getDoctrine()->getManager();

		$post = new RedditPost();
		$post->setTitle('hello me, I\m new article ! ' . $text);

		$em->persist($post);
		$em->flush();


		return $this->redirectToRoute('list');
	}

	/**
	* @Route("list/update/{id}/{text}", name="update")
	*/
	public function updateAction($id, $text) 
	{
		$em = $this->getDoctrine()->getManager();

		$post = $em->getRepository('AppBundle:RedditPost')->find($id);
		/** @var $post RedditPost */
		
		if(!post){
			throw $this->createNotoundException('404');
		}
		$post->setTitle('update title ' . $text);

		$em->flush();

		return $this->redirectToRoute('list');
	}

	/**
	* @Route("list/delete/{id}", name="delete")
	*/
	public function deleteAction($id)
	{

		$em = $this->getDoctrine()->getManager();

		$post = $em->getRepository('AppBundle:RedditPost')->find($id);
		/** @var $post RedditPost */
		$em->remove($post);
		$em->flush();

		return $this->redirectToRoute('list');

	}

	/**
	* @Route("/scraper", name="scraper	")
	*/
	public function scraperAction()
	{
		$result = $this->get('reddit_scraper')->scrape();
		dump($result);

		return $this->render('reddit/index.html.twig', [
			'posts' => [],
		]);
	}
}