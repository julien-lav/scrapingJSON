<?php 

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
* Class RedditPost
* @package AppBundle\Entity
*
* @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RedditPostRepository")
* @ORM\Table(name="reddit_posts")
*/
class RedditPost 
{

	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/	
	protected $id;


	/**
	* @ORM\Column(type="string")
	*/
	protected $title;

	/**
	* @ORM\ManyToOne(targetEntity="AppBundle\Entity\RedditAuthor", inversedBy="posts")
	* @ORM\JoinColumn(name="author_id", referencedColumnName="id")
	*/
	protected $author;

	/**
	* @return mixed
	*/
	public function getTitle()
	{
		return $this->title;
	}


	/*
	* @param mixed $title
	* @return RedditPost
	*/
	public function setTitle($title)
	{
		$this->title= $title;

		return $this;
	}
	/**
	* @return mixed
	*/
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	* @param mixed $author
	* @return RedditPost
	*/
	public function setAuthor(RedditAuthor $author)
	{
		$this->author = $author;

		return $this;
	}
	
}
