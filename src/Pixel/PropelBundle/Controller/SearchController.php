<?php

namespace Pixel\PropelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pixel\BootstrapBundle\Model\BookQuery;
use Pixel\UserBundle\Model\UserQuery;

class SearchController extends Controller
{
    /**
     * @Route("/search/{q}", name="propel_search", defaults={"q" = null})
     * @Template()
     */
    public function indexAction($q)
    {
        $query = trim($this->get('request')->query->get('q'));

        $results = BookQuery::create()
            ->findByTitle('%'.$query.'%');

        return array('query' => $query, 'results' => $results);
    }

}
