<?php
//session_start();
//require_once($_SERVER["DOCUMENT_ROOT"]."/erp/pages/includes/functions.php");
//$employee_id = $_SESSION['employee_id'];
//$image_name = $_FILES['product_image']['name'];
//$image_size = $_FILES['product_image']['size'];
//$temp_name = $_FILES['product_image']['tmp_name'];
//$file_type = $_FILES['product_image']['type'];
//
//$file_extension = strtolower(end(explode(".", $image_name)));
//echo "image name: " .$image_name;
//echo "<br> Image size : $image_size";
//echo "<br> temp name : $temp_name";
//echo "<br> file type : $file_type";
//echo "<br> file extension : $file_extension";
//
//$valid_extensions = array("jpeg", "jpg", "png");
//
//if(in_array($file_extension, $valid_extensions) == false){
//    $error_msg[] = "Image is not valid! Please choose a JPEG or PNG file!";
//}
//
//if($image_size>2097152){
//    $error_msg[] = "Image size is too huge! Please slect image within 2MB size"; 
//}
//
//if(empty($error_msg)){
//    move_uploaded_file($temp_name, "../../../assets/product/images/".$image_name);
//    echo "File successfully uploaded";
//}else{
//  print_r($error_msg);  
//}

if(isset($_POST['add_product'])){
    //Checking whether the file was uploaded or not!
    if(isset($_FILES['product_image'])){
        $image_name = $_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $temp_name = $_FILES['product_image']['tmp_name'];
        $file_type = $_FILES['product_image']['type'];
        $file_extension = strtolower(end(explode(".", $image_name)));
        
        

    }
    $product_name = $_POST['product_name'];
    $rate_of_sale = $_POST['rate_of_sale'];
    $additional_specification = $_POST['additional_specification'];
    $category_id = $_POST['category_id'];
    $eoq = $_POST['eoq'];
    $suppliers = $_POST['supplier_id'];
    
    $tablename = "product";
    $columns = "product_name , eoq, additional_specification , category_id , image_extension,  created_by";
    $values = "'$product_name', $eoq, '$additional_specification', $category_id ,'$file_extension', $employee_id";
    
    $result = insert($tablename, $columns, $values);
    //product has been added
    
    //getting the last product_id which was automatically created by DBMS
    $product_id = mysqli_insert_id($connection);
    
    $tablename = "product_sale_rate";
    $columns = "product_id, rate_of_sale, wef, created_by";
    $values = "$product_id, $rate_of_sale, now(), $employee_id";
    $result = insert($tablename, $columns, $values);
    
    $tablename = "product_supplier";
    $columns = "product_id, supplier_id";
    foreach($suppliers as $supplier_id){
        $values = "$product_id, $supplier_id";
        $result = insert($tablename, $columns, $values);
    }
    
    /* Code to upload the file*/
    if(isset($_FILES['product_image'])){
        move_uploaded_file($temp_name, "../../../assets/product/images/".$product_id.".".$file_extension);
    }
    echo "ADDED";
    $_SESSION['status'] = CUSTOMER_ADD_SUCCESS;
}
?>