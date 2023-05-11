<?php 
    class BillModel{
        private $Bill;
        public function __construct(){
            $db = new Database();
            $query = "SELECT 
            hoadons.*,
            accounts.full_name AS 'kh_full_name',accounts.user_id,
            IFNULL(staff_accounts.full_name, '') AS 'nv_full_name'
        FROM 
            hoadons
        INNER JOIN 
            accounts ON hoadons.user_kh = accounts.user_id
        LEFT JOIN 
            staff ON hoadons.user_nv = staff.nv_user_id
        LEFT JOIN 
            accounts AS staff_accounts ON staff.user_id = staff_accounts.user_id
        WHERE 
            hoadons.user_nv IS NULL OR staff.nv_user_id IS NOT NULL";
            $result = $db->select($query);
            if($result!=false){
                while($value = $result->fetch_assoc()) {
                    $bill[] = $value; // Thêm mảng kết quả vào mảng output
                }
                    $this->Bill = $bill;
            }
            else
                $this->Bill=false;
        }
        public function getBill(){
            return $this->Bill;
        }
        public function getBill_ByUser($user_id){
            $output = [];
            foreach ($this->Bill as $value) {
                if($value["user_id"]==$user_id)
                    array_push($output,$value);
            }
            if(count($output)<1)
                return false;
            return $output;
        }
        public function getBill_ByID($ID){
        $db = new Database();
        $query = "SELECT chitiethoadons.*, sanphams.img, sanphams.name, sanphams.price,thuonghieus.name AS `tenthuonghieu` FROM hoadons
        LEFT JOIN chitiethoadons ON hoadons.bill_id = chitiethoadons.bill_id
        LEFT JOIN sanphams ON chitiethoadons.product_id = sanphams.product_id
        LEFT JOIN thuonghieus ON thuonghieus.brand_id = sanphams.brand_id 
       WHERE hoadons.bill_id = '$ID'";
                $result = $db->select($query);
                while($value = $result->fetch_assoc()) {
                    $bill[] = $value; // Thêm mảng kết quả vào mảng output
                }
            return $bill;
            
        }
        public function editBill($bill_id,$status,$date_receice){
            $db = new Database();
            if($status>3){
                $query = "SELECT chitiethoadons.product_id,chitiethoadons.amount FROM `chitiethoadons` WHERE chitiethoadons.bill_id = '$bill_id'";
                $result = $db->select($query);
                while($value = $result->fetch_assoc()) {
                    $carts[] = $value; // Thêm mảng kết quả vào mảng output
                }
                $productClass = new ProductModel();
                foreach ($carts as $value) {
                    $productClass->updateAmountadd($value["product_id"],$value["amount"]);
                }
            } 
            $staff_id = Session::get("ID_ADMIN_login");
            $query = "SELECT staff.nv_user_id FROM staff,accounts WHERE accounts.user_id=staff.user_id AND accounts.user_id='$staff_id'";
            $result = $db->select($query);
            $staff=$result->fetch_assoc();
            $query = "UPDATE `hoadons` SET `user_nv`='".$staff["nv_user_id"]."',`date_receice`='$date_receice',`status`='$status' WHERE bill_id='$bill_id'";
            try {
                if($result = $db->update($query)){
                        echo json_encode(array('textRely' => 'success'));
                    
                } else {
                    echo json_encode(array('textRely' => 'fail'));
                }
            } catch(mysqli_sql_exception $ex) {
                if($ex->getCode() == 1062){ // Error code 1062 = Duplicate entry error
                    echo json_encode(array('textRely' => 'fail'));
                } else {
                    throw $ex;
                }
            }
            
        }
        public function getValueThongKe(){
            $db = new Database();
            $query = "SELECT hoadons.bill_id,hoadons.date_order,hoadons.total,hoadons.user_kh,
            chitiethoadons.product_id,chitiethoadons.amount,thuonghieus.brand_id,thuonghieus.name AS `tenthuonghieu`
            ,sanphams.name AS `tensanpham`,sanphams.product_type_id, sanphams.amount AS `soluongton`,
            sanphams.img AS `image`,sanphams.price*chitiethoadons.amount AS `price`,hoadons.status
            FROM hoadons,chitiethoadons,sanphams,thuonghieus
            WHERE hoadons.bill_id=chitiethoadons.bill_id
            AND sanphams.product_id=chitiethoadons.product_id
            AND sanphams.brand_id=thuonghieus.brand_id
            AND hoadons.status<=3
            AND hoadons.status>1
            ";
            $result = $db->select($query);
            while ($value = $result->fetch_assoc()) {
                $output[] = $value;
            }
            return $output;
        }
        public function getValueThongKe2($checkertime,$typeproduct,$amounter){
            $db = new Database();
            $output1=[];
            $output2=[];
            $output3=[];

            $querytime = " ";
            if($checkertime!=""){
                $gettime = explode(",",$checkertime);
                $querytime = "AND STR_TO_DATE(hoadons.date_order, '%d-%m-%Y') >= STR_TO_DATE('".$gettime[0]."', '%d-%m-%Y')
                AND STR_TO_DATE(hoadons.date_order, '%d-%m-%Y') <= STR_TO_DATE('".$gettime[1]."', '%d-%m-%Y') 
                ";
            }
            $querytype=' ';
            if($typeproduct!="")
                $querytype = " AND sanphams.product_type_id = '$typeproduct' ";

            $queryamount =" ";
            if($amounter!="")
                $queryamount = " AND chitiethoadons.amount>=$amounter ";

            $query = "SELECT DATE_FORMAT(STR_TO_DATE(date_order, '%d-%m-%Y'), '%m-%Y') AS monthyear, SUM(sanphams.price*chitiethoadons.amount) AS price, COUNT(*) AS countbill
            FROM hoadons,sanphams,chitiethoadons
            WHERE hoadons.bill_id=chitiethoadons.bill_id
                AND sanphams.product_id=chitiethoadons.product_id
            GROUP BY DATE_FORMAT(STR_TO_DATE(date_order, '%d-%m-%Y'), '%m-%Y')            
            ";
            if( $querytime!= " "||$querytype!=" "||$queryamount!=" "){
                $query = "SELECT DATE_FORMAT(STR_TO_DATE(date_order, '%d-%m-%Y'), '%m-%Y') AS monthyear, SUM(sanphams.price*chitiethoadons.amount) AS price, COUNT(*) AS countbill
                FROM hoadons,sanphams,chitiethoadons
                WHERE hoadons.bill_id=chitiethoadons.bill_id
                AND sanphams.product_id=chitiethoadons.product_id
                ".$querytime." ".$querytype." ".$queryamount."
                GROUP BY DATE_FORMAT(STR_TO_DATE(date_order, '%d-%m-%Y'), '%m-%Y')            
                ";
            }
            $sql1 = $query;
            // return $sql1;
            // exit();
            $result = $db->select($query);
            if($result)
                while ($value = $result->fetch_assoc()) {
                    $output1[] = $value;
                }           
            $query = "SELECT chitiethoadons.product_id,chitiethoadons.amount, SUM(sanphams.price*chitiethoadons.amount) AS price, sanphams.amount AS `soluongton`, sanphams.name AS `name_sp`, sanphams.img,sanphams.product_type_id
            FROM chitiethoadons,hoadons,sanphams
            WHERE chitiethoadons.product_id = sanphams.product_id
            AND chitiethoadons.bill_id = hoadons.bill_id
             ".$querytime.$querytype." ".$queryamount." 
            GROUP BY chitiethoadons.product_id
            ";
            $sql2 = $query;
            // return $sql;
            // exit();
            $result = $db->select($query);
            if($result)
                while ($value = $result->fetch_assoc()) {
                    $output2[] = $value;
                }
            $query = "SELECT sanphams.brand_id,sanphams.name AS `name_brand`, SUM(sanphams.price*chitiethoadons.amount) AS `total`
            FROM chitiethoadons,sanphams,hoadons
            WHERE chitiethoadons.product_id = sanphams.product_id
            AND chitiethoadons.bill_id = hoadons.bill_id
             ".$querytime.$querytype." ".$queryamount."
            GROUP BY sanphams.brand_id
            ";
            $sql3 = $query;
            // return $sql;
            // exit();
            $result = $db->select($query);
            if($result)
                while ($value = $result->fetch_assoc()) {
                    $output3[] = $value;
                }
            return (array('hoadonthoigian' =>  $output1,'sanpham'=> $output2,'thuonghieu'=>$output3,"sql1"=>$sql1,"sql2"=>$sql2,"sql3"=>$sql3));
        }
    }
    
?>