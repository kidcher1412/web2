<?php
     require_once('../model/UserModel.php');
     require_once('../model/ProductModel.php');
    class Register{
        private $db;
        public function __construct(){
          $this->db = new Database();
       }
       public function index(){
          $categoryclass = new ProductModel();
          $categoryData = $categoryclass->getType();
        include('../page/header.php');
        include('../view/RegisterView.php');
        include('../view/BannerView.php');
        include('../page/footer.php');
       }
       public function checkusername($username){
            $userclass = new User();
            echo json_encode($userclass->getUser_ByUserName($username));
       }
       public function registerUser($user,$pass,$full_name,$phone,$mail,$address,$sex,$dateborn){
            $userclass = new User();
            $userclass->registerUser($user,$pass,$full_name,$phone,$mail,$address,$sex,$dateborn);
       }
    }
?>