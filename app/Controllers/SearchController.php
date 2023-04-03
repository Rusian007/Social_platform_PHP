<?php
require_once 'db config.php';
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

    public function search(){

        $handle = new db();
        $db = $handle->connect();
        // Get the search query from the $_GET superglobal
        $query = $_GET['q'];
        $query = "%".$query."%";

        // Construct the SELECT statement
        $sql = "SELECT * FROM posts WHERE post_title LIKE ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $query);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the search results
        $results = [];
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        // Return the search results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    }

    public function showpost(){

        if(isset( $_GET['post_id'])){
               $postid = $_GET['post_id'];
                session_start();
               $_SESSION['post_id'] = $postid;
               
             header('Location: '.'/Social_platform_PHP/app/Views/search/searchpost.html.php');
               
        } else{
            echo "Nothing Found !";
        }
    

          exit;
    }

}