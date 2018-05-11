<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* Class RedditAuthor
* @package AppBundle\Entity
*
* @ORM\Entity
* @ORM\Table(name="reddit_author", indexes={
	@ORM\Index(name="index_author_name", columns={"name"})
})
*/
class RedditAuthor 
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/	
	protected $id;

	/**
	* @ORM\Column(type="string", unique=true)
	*/
	protected $name;

	/**
	* @ORM\OneToMany(targetEntity="AppBundle\Entity\RedditPost", mappedBy="author")
	*/
	protected $posts;

	public function __construct()
	{
		$this->posts = new ArrayCollection();
	}

	/**
	* @return mixed
	*/
	public function getName()
	{
		return $this->name;
	} 

	/**
	* @param mixed $name
	* @return RedditAuthor
	*/
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	* @param mixed
	*/
	public function getPosts()
	{
		return $this->posts;
	}
	/**
	* @param mixed $posts
	* return RedditAuthor
	*/
	public function setPost($posts)
	{
		$this->posts = $posts;
	}
	public function addPost(RedditPost $redditPost)
    {
        if ( ! $this->posts->contains($redditPost)) {
            $redditPost->setAuthor($this); 
            $this->posts->add($redditPost);
        }

        return $this;
    }
}	