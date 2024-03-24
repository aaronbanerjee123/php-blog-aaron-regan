<?php
function query(string $query, array $data = []){
    $string = "mysql:hostname=".DBHOST.";dbname=". DBNAME;
    $con = new PDO($string, DBUSER,DBPASS);

    $stm = $con->prepare($query); 
    $stm->execute($data);
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(is_array($result) && !empty($result)){
        return $result;
    }

    return false;
}


function query_row(string $query, array $data = []){
    $string = "mysql:hostname=".DBHOST.";dbname=". DBNAME;
    $con = new PDO($string, DBUSER,DBPASS);

    $stm = $con->prepare($query); 
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(is_array($result) && !empty($result)){
        return $result[0];
    }

    return false;
}

function esc($str) {
    return htmlspecialchars($str ?? '');
}



// function redirect($page){
//     header('Location: '.$page);
//     die;
// }

function redirect_login(){
    header('Location: http://localhost/blog/public/login/');


    die;
}


function redirect_home(){
    header('Location: http://localhost/blog/public/index.php');


    die;
}


function redirect_admin(){
    header('Location: http://localhost/blog/public/admin/');
    die;
}

function redirect_admin_users(){
    header('Location: http://localhost/blog/public/admin/users');
    die;
}




function redirect_admin_categories(){
    header('Location: http://localhost/blog/public/admin/categories');
    die;
}

function redirect_admin_posts(){
    header('Location: http://localhost/blog/public/admin/posts');
    die;
}

function redirect_admin_myblogs(){
    header('Location: http://localhost/blog/public/myblogs');
    die;
}



function redirect_settings(){
    header('Location: http://localhost/blog/public/settings');
    die;
}



function old_value($key, $default = ''){
    if(!empty($_POST[$key])){
        return $_POST[$key];
    }


    return $default;
}


function old_checked($key){
    if(!empty($_POST[$key])){
        return "checked";
    }
    return "";
}

function image() {
    echo $_FILES['image'];
}

function get_image($file){
    $file = $file ?? '';

    if(file_exists($file)){
        return ROOT . '/' .$file;
    }

    return ROOT.'/assets/images/no_image.jpg';
}

function authenticate($row){
    $_SESSION['USER'] = $row[0];
}


function user($key=''){
    if(empty($key)){
        return $_SESSION['USER'];
    }
    if(!empty($_SESSION['USER'][$key])){
        return $_SESSION['USER'][$key];
    }

    return '';
}


function logged_in(){
    if(!empty($_SESSION['USER'])){
        return true;
    }
    return false;
}

function str_to_url($url){
    $url = str_replace("'","",$url);
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9]+~', '',$url);

    return $url;
}

function get_pagination_vars(){
       //pagination
       $page_number = $_GET['page'];
       $page_number = (empty($page_number) || $page_number<1) ? 1 : (int)$page_number;
       // $page_number = $page_number < 1 ? 1 : $page_number;
   
       $current_link = $_GET['url'] ?? 'home';
       $current_link = ROOT . "/" .$current_link;
   
       $query_string = "";
   
       foreach($_GET as $key => $value){
           if($key != 'url'){
               if($key == 'page' && $value < 1){
                   $query_string .= "&".$key."=1";
               }else{
                   $query_string .= "&".$key."=".$value;
               }
           }
       }
   
   
       if(!strstr($query_string, "page=")){
           $query_string .= "&page=".$page_number;
       }
   
       $query_string = trim($query_string, "&");
   
       $prev_page_number = $page_number - 1 <= 0 ? 1 : $page_number-1;
   
       $current_link .= "?".$query_string;
   
       $first_link = preg_replace("/page=[\w0-9]+/","page=1",$current_link);
   
       $next_link = preg_replace("/page=[\w0-9]+/","page=".($page_number+1),$current_link);
       
       $prev_link= preg_replace("/page=[\w0-9]+/","page=".($prev_page_number),$current_link);
       
       $result = [
        'current_link'  =>$current_link,
        'first_link'    => $first_link,
        'next_link'     => $next_link,
        'prev_link'     => $prev_link,
        '$page_number' => $page_number
       ];

       return $result;
}




create_tables();
function create_tables(){
    try {
    $string = "mysql:hostname=".DBHOST.";";
    $con = new PDO($string, DBUSER,DBPASS);

    $query = "CREATE DATABASE IF NOT EXISTS ".DBNAME;
    $stm = $con->prepare($query); 
    $stm->execute();


    $query = "use ". DBNAME;
    $stm = $con->prepare($query); 
    $stm->execute();

    // print_r($con);
    $query = "create table if not exists users(
        id int primary key auto_increment,
        username varchar(50) not null,
        email varchar(100) not null,
        password varchar(255) not null,
        image varchar(1024) null,
        date datetime default current_timestamp,
        role varchar(10) not null,

        key username (username),
        key email (email)

    )";
    $stm = $con->prepare($query); 
    $stm->execute();

    $query = "create table if not exists categories(
        id int primary key auto_increment,
        category varchar(50) not null,
        slug varchar(100) not null,
        disabled tinyint default 0,

        key slug (slug),
        key category (category)

    )";
    $stm = $con->prepare($query); 
    $stm->execute();

    $query = "create table if not exists posts(
        id int primary key auto_increment,
        user_id int,
        category_id int,
        title varchar(100) not null,
        content text null,
        image varchar(1024) null,
        date datetime default current_timestamp,
        slug varchar(100) not null,

        key user_id (user_id),
        key category_id (category_id),
        key date (date),
        key slug (slug)
    )";

    $stm = $con->prepare($query); 
    $stm->execute();

    $query = "create table if not exists comments(
        id int primary key auto_increment,
        post_id int,
        comment text null,
        user_id int,
        date datetime default current_timestamp
    )";

    $stm = $con->prepare($query); 
    $stm->execute();

    }catch(PDOException $e){
        echo $e;
    }
 }


 function resize_image($filename,$max_size = 1000){

    if(file_exists($filename)){
        $type = mime_content_type($filename);
        switch ($type){
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filename);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filename);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($filename);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filename);
                break;
        }

        $src_width = imagesx($image);
        $src_height = imagesy($image);

        if($src_width > $src_height){
            if($src_width < $max_size){
                $max_size = $src_width;
            }
            $dst_width = $max_size;
            $dst_height = ($src_width/$src_height) * $max_size; 


        }else{
            if($src_height < $max_size){
                    $max_size = $src_width;
            }
                $dst_height = $max_size;
                $dst_width = ($src_width/$src_height) * $max_size;
        }

        $dst_height = round($dst_height);
        $dst_width = round($dst_width);

        $dst_image = imagecreatetruecolor($dst_width, $dst_height);
        imagecopyresampled($dst_image,$image,0,0,0,0,$dst_width, $dst_height,$src_width,$src_height);
 

        switch ($type){
            case 'image/jpeg':
                imagejpeg($dst_image,$filename,90);
                break;
            case 'image/png':
                imagepng($dst_image,$filename,90);
                break;
            case 'image/gif':  
                imagegif($dst_image,$filename,90);
                break;
            case 'image/webp':
                imagewebp($dst_image,$filename,90);
                break;
        }

    }

 }

 
    