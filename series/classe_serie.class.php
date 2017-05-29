<?php
	class Serie
	{
        private $id;
        private $name;
        private $year;
        private $country;
        private $summary;
        private $nb_seasons;
        private $actors; //array of perso
        private $producers; //array of perso
        private $creators; //array of perso
        private $directors; //array of perso
        private $genres; //array of genres
        private $cover; //url
        private $poster; //url
        private $background; //url
        private $reviews; //array of reviews
        private $seasons_episodes; //array of episodes where is a season's number and the associated value is an array, from 0 to n-1, with n episodes 
    	//constructeur
      	public function __construct($series_infos)
      	{
    	    $this->setId($series_infos["id"]);
    	    $this->setName($series_infos["name"]);
    	    $this->setYear($series_infos["year"]);
    	    $this->setCountry($series_infos["country"]);
    	    $this->setSummary($series_infos["summary"]);
    	    $this->setNbseasons($series_infos["nb_seasons"]);
    	    $this->setActors($series_infos["actors"]);
    	    $this->setProducers($series_infos["producers"]);
    	    $this->setCreators($series_infos["creators"]);
    	    $this->setDirectors($series_infos["directors"]);
    	    $this->setGenres($series_infos["genres"]);
            $this->setCover($series_infos["cover"]);
    	    $this->setPoster($series_infos["poster"]);
            $this->setBackground($series_infos["background"]);
    	    $this->setReviews($series_infos["reviews"]);
    	    $this->setEpisodes($series_infos["seasons_episodes"]);
      	}
      	//accesseurs
      	public function getId()
      	{
      		return $this->id;
      	}
    	public function getName()
    	{
      		return $this->name;
      	}
    	public function getYear()
    	{
      		return $this->year;
      	}
    	public function getCountry()
    	{
      		return $this->country;
      	}
    	public function getSummary()
    	{
      		return $this->summary;
      	}
    	public function getNbseasons()
    	{
      		return $this->nb_seasons;
      	}
    	public function getActors()
    	{
      		return $this->actors;
      	}
    	public function getProducers()
    	{
      		return $this->producers;
      	}
    	public function getCreators()
    	{
      		return $this->creators;
      	}
    	public function getDirectors()
    	{
      		return $this->directors;
        }
    	public function getGenres()
    	{
      		return $this->genres;
        }
        public function getCover()
        {
            return $this->cover;
        }
    	public function getPoster()
    	{
      		return $this->poster;
        }
        public function getBackground()
        {
            return $this->background;
        }
    	public function getReviews()
    	{
      		return $this->reviews;
      	}
    	public function getEpisodes()
    	{
      		return $this->seasons_episodes;
      	}
      	//mutateurs
      	public function setId($id)
      	{
      		$this->id=$id;
      	}
      	public function setName($name)
      	{
      		$this->name=$name;
      	}
      	public function setYear($year)
      	{
      		$this->year=$year;
      	}
      	public function setCountry($country)
      	{
      		$this->country=$country;
      	}
      	public function setSummary($summary)
      	{
      		$this->summary=$summary;
      	}
      	public function setNbseasons($nb_seasons)
      	{
      		$this->nb_seasons=$nb_seasons;
      	}
      	public function setActors($actors)
      	{
      		$this->actors=$actors;
      	}
      	public function setProducers($producers)
      	{
      		$this->producers=$producers;
      	}
      	public function setCreators($creators)
      	{
      		$this->creators=$creators;
      	}
      	public function setDirectors($directors)
      	{
      		$this->directors=$directors;
      	}
      	public function setGenres($genres)
      	{
      		$this->genres=$genres;
      	}
        public function setCover($cover)
        {
            $this->cover=$cover;
        }
      	public function setPoster($poster)
      	{
      		$this->poster=$poster;
      	}
        public function setBackground($background)
        {
            $this->background=$background;
        }
      	public function setReviews($reviews)
      	{
      		$this->reviews=$reviews;
      	}
      	public function setEpisodes($seasons_episodes)
      	{
      		$this->seasons_episodes=$seasons_episodes;
      	}
    }
?>