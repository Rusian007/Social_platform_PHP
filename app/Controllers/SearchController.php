<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/29/2023
 * Time: 4:24 AM
 */
class SearchController
{
    public function index(){
        header('Location: '.'/Social_platform_PHP/app/Views/search/search.html.php');
        exit;
    }

}