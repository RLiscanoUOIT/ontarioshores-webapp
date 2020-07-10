<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
<title>Ontario Shores</title>
<link rel="stylesheet" href="css/frontpage.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<body>
 <!-- service_area_start  -->
 <div class = "logo">
      <img src="logo100.png" class="image1">
    </div>
    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-7 col-md-10">
                    <div class="section_title text-center mb-95">
                        <h3>Reminiscence Therapy</h3>
                    </div>
                </div>
            </div>
            <!--Staff login button-->
			<div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
								 <a style="text-decoration:none; color:black" href="<?php echo "staff/stafflogin.php"; ?>">
                    <div class="single_service">
                         <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
							 <div class="service_icon">
								 <img src="img/service/service_icon_1.png" alt="">
								 
                             </div>
                         </div>
                         <div class="service_content text-center">
                            <h3>STAFF</h3>
                         </div>
                    </div></a>
					
                </div>
				
		<!--Admin login button-->
                <div class="col-lg-4 col-md-6">
                                 <a style="text-decoration:none; color:black" href="<?php echo "admin/adminlogin.php"; ?>">
                    <div class="single_service active">
                         <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                             <div class="service_icon">
								 <img src="img/service/service_icon_2.png" alt="">
                             </div>
				 </div>

                         <div class="service_content text-center">
                            <h3>ADMIN</h3>
                         </div>
                    </div>
					 				 </a>

                </div>
			
		<!--Caregiver login button-->
                <div class="col-lg-4 col-md-6">
                                 <a style="text-decoration:none; color:black" href="<?php echo "caregiverlogin.php"; ?>">
                    <div class="single_service">
                         <div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">
                             <div class="service_icon">
								 <img src="img/service/service_icon_3.png" alt="">
								 
                             </div>
                         </div>
                         <div class="service_content text-center">
                            <h3>CAREGIVER</h3>
                         </div>
                    </div>
			</a>
                </div>
            </div>
        </div>
    </div>
    <!-- service_area_end -->
</body>
</html>
