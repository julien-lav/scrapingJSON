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
		//$posts = $this->getDoctrine()->getRepository('AppBundle:RedditPost')->findAll();

		/*$query = $this->getDoctrine()->getManager()->createQuery(
			"
			SELECT p, a
			FROM AppBundle\Entity\RedditPost p
			JOIN p.author a
			WHERE p.id >= :id
			ORDER BY a.name DESC
			"
		)->setParameter('id', 1);

		$posts = $query
			->setFirstResult(200)
			->setMaxResults(5)
			->getResult();
		*/
		/*
		$query = $this->getDoctrine()->getRepository('AppBundle:RedditPost')
			->createQueryBuilder('p')
			->join('p.author', 'a')
			->addSelect('a')
			->where('p.id > :id')
			->setParameter('id', 10)
			->orderBy('a.name', 'DESC')
			->getQuery();

			// if($i > 10){$query->where('')}
		
		$posts = $query->getResult();	
		*/
		$posts = $this
			->getDoctrine()
			->getRepository('AppBundle\Entity\RedditPost')	
			->someQueryWeCareAbout(20);

			
		dump($posts); 

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