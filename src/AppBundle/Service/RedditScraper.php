<?php 

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\RedditPost;
use AppBundle\Entity\RedditAuthor;



class RedditScraper
{
	/**
	* @var EntityManagerInterface
	*/
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em =$em;
	}

	public function scrape()
	{
		$client = new \GuzzleHttp\Client();
		$after = null;

		for ($i=0; $i<5; $i++)
		{
		$response = $client->request('GET', 'https://api.reddit.com/r/php.json?limit=25&after=' . $after); 

		$contents[$i] = json_decode($response->getBody()->getContents(), true);

		$after = $contents[$i]['data']['after'];
		}

		foreach ($contents as $content) {
			foreach ($content['data']['children'] as $child) 
			{
				$redditPost = new RedditPost();
				$redditPost->setTitle($child['data']['title']);

				$redditAuthor = $this->em->getRepository('AppBundle:RedditAuthor')->findOneBy([
					'name' => $child['data']['author'],
				]); 
					if(!$redditAuthor) 
					{
						$redditAuthor = new RedditAuthor();
						$redditAuthor->setName($child['data']['author']);
						$this->em->persist($redditAuthor);
						$this->em->flush();

					}
				$redditAuthor->addPost($redditPost);

				$this->em->persist($redditPost);
			}
		}
		$this->em->flush();
	}
}


