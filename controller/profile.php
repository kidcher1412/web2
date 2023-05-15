<?php 
    require_once("../model/BillModel.php");
    require_once('../model/ProfileModel.php');
    require_once('../model/UserModel.php');
    require_once('../model/ProductModel.php');

    class Profile{
        public function index() {
            $classBill = new BillModel();
            $ProfileData = $this->getdata_user_login();
            // echo json_encode($ProfileData);
            // $BillData=$classBill->getBill_ByUser($ProfileData["kh_user_id"]);
            $BillData=$classBill->getBill_ByUserprofile($ProfileData["kh_user_id"]);
            $categoryclass = new ProductModel();
            $categoryData = $categoryclass->getType();
            // echo json_encode($BillData);
            include('../page/header.php');
            include('../view/ProfileView.php');
            include('../page/footer.php');
        }
        public function getView() {
            include('../view/ProfileView.php');
        }
        public function getdata_user_login(){
            $class2 = new User();
            return $class2->getProfileKH();
        }
        public function updatePasswordAccount($user_id,$oldpass,$newpass){
            $class2 = new User();
            return $class2->updatePasswordAccount($user_id,$oldpass,$newpass);
        }

        public function Logout_User(){
            Session::init();
            Session::logout_User();
            header("Location:../home/");
        }
        public function editCustommer($userID, $user, $pass, $full_name, $phone, $mail, $address, $sex, $dateborn){
            $userclass=new User();
            $userclass->editCustommer($userID, $user, $pass, $full_name, $phone, $mail, $address, $sex, $dateborn);
        }
        public function editbill($bill_id){
            $userclass=new BillModel();
            $userclass->cancelBill($bill_id,4);
            exit();
        }
    }
?>