<?php
	class Personnalite
	{
        private $id;
        private $fname;
        private $lname;
        private $photo;
        private $poster;
        private $jobs; //array of job
        private $series; //array of series
    	//constructeur
      	public function __construct($personnalites_infos)
      	{
    	    $this->setId($personnalites_infos["id"]);
    	    $this->setFname($personnalites_infos["fname"]);
    	    $this->setLname($personnalites_infos["lname"]);
    	    $this->setPhoto($personnalites_infos["photo_ind"]);
    	    $this->setPoster($personnalites_infos["poster"]);
    	    $this->setJobs($personnalites_infos["jobs"]);
    	    $this->setSeries($personnalites_infos["series"]);
      	}
      	//accesseurs
      	public function getId()
      	{
      		return $this->id;
      	}
    	public function getFname()
    	{
      		return $this->fname;
      	}
    	public function getLname()
    	{
      		return $this->lname;
      	}
    	public function getPhoto()
    	{
      		return $this->photo;
      	}
    	public function getPoster()
    	{
      		return $this->poster;
      	}
    	public function getJobs()
    	{
      		return $this->jobs;
      	}
    	public function getSeries()
    	{
      		return $this->series;
      	}
      	//mutateurs
      	public function setId($id)
        {
            $this->id=$id;
        }
        public function setFname($fname)
        {
            $this->fname=$fname;
        }
        public function setLname($lname)
        {
            $this->lname=$lname;
        }
        public function setPhoto($photo)
        {
            $this->photo=$photo;
        }
        public function setPoster($poster)
        {
            $this->poster=$poster;
        }
        public function setJobs($jobs)
        {
            $this->jobs=$jobs;
        }
        public function setSeries($series)
        {
            $this->series=$series;
        }
    }
?>