	  
      <!--/Login-->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="login px-4 py-4 mx-auto mw-100">
                     <h5 class="text-center mb-4">Login Now</h5>
                     <form action="#" method="post">
                        <div class="form-group">
                           <p class="mb-2">Email address</p>
                           <input type="email" class="form-control" id="exampleInputEmail1"  placeholder="" required="">
                        </div>
                        <div class="form-group">
                           <p class="mb-2">Password</p>
                           <input type="password" class="form-control" id="exampleInputPassword1" placeholder="" required="">
                        </div>
                        <div class="form-check mb-3">
                           <input type="checkbox" class="form-check-input" id="exampleCheck1">
                           <p class="form-check-p">Check me out</p>
                        </div>
                        <button type="submit" class="btn submit">Sign In</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--//Login-->
	  
	  
      <!--/Login-->
      <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="login px-4 py-4 mx-auto mw-100">
                     <h5 class="text-center mb-4">Tiga</h5>
                     <form action="#" method="post">
                        <div class="form-group">
                           <p class="mb-2">Email address</p>
                           <input type="email" class="form-control" id="exampleInputEmail1"  placeholder="" required="">
                        </div>
                        <div class="form-group">
                           <p class="mb-2">Password</p>
                           <input type="password" class="form-control" id="exampleInputPassword1" placeholder="" required="">
                        </div>
                        <div class="form-check mb-3">
                           <input type="checkbox" class="form-check-input" id="exampleCheck1">
                           <p class="form-check-p">Check me out</p>
                        </div>
                        <button type="submit" class="btn submit">Sign In</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--//Login-->
	  
      <!--/Register-->
      <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="login px-4 py-4 mx-auto mw-100">
                     <h5 class="text-center mb-4">Register Now</h5>
                     <form action="#" method="post">
                        <div class="form-group ">
                           <p class="mb-2">First name</p>
                           <input type="text" class="form-control" id="validationDefault01" placeholder="" required="">
                        </div>
                        <div class="form-group">
                           <p class="mb-2">Last name</p>
                           <input type="text" class="form-control" id="validationDefault02" placeholder="" required="">
                        </div>
                        <div class="form-group">
                           <p class="mb-2">Password</p>
                           <input type="password" class="form-control" id="password1" placeholder="" required="">
                        </div>
                        <div class="form-group">
                           <p class="mb-2">Confirm Password</p>
                           <input type="password" class="form-control" id="password2" placeholder="" required="">
                        </div>
                        <button type="submit" class="btn submit ">Register</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--//Register-->
      <!--js working-->
      <script src='js/jquery-2.2.3.min.js'></script>
      <!--//js working--> 
      <!--responsiveslides banner-->
      <script src="js/responsiveslides.min.js"></script>
      <script>
         // You can also use "$(window).load(function() {"
         $(function () {
         	// Slideshow 4
         	$("#slider4").responsiveSlides({
         		auto:true,
         		pager:false,
         		nav:true,
         		speed: 900,
         		namespace: "callbacks",
         		before: function () {
         			$('.events').append("<li>before event fired.</li>");
         		},
         		after: function () {
         			$('.events').append("<li>after event fired.</li>");
         		}
         	});
         
         });
      </script>
      <!--// responsiveslides banner-->	 
      <!--About OnScroll-Number-Increase-JavaScript -->
      <script src="js/jquery.waypoints.min.js"></script>
      <script src="js/jquery.countup.js"></script>
      <script>
         $('.counter').countUp();
      </script>
      <!-- //OnScroll-Number-Increase-JavaScript -->  
      <!-- start-smoth-scrolling -->
      <script src="js/move-top.js"></script>
      <script src="js/easing.js"></script>
      <script>
         jQuery(document).ready(function ($) {
         	$(".scroll").click(function (event) {
         		event.preventDefault();
         		$('html,body').animate({
         			scrollTop: $(this.hash).offset().top
         		}, 900);
         	});
         });
      </script>
      <!-- start-smoth-scrolling -->
      <!-- here stars scrolling icon -->
      <script>
         $(document).ready(function () {
         
         	var defaults = {
         		containerID: 'toTop', // fading element id
         		containerHoverID: 'toTopHover', // fading element hover id
         		scrollSpeed: 1100,
         		easingType: 'linear'
         	};
         
         
         	$().UItoTop({
         		easingType: 'easeOutQuart'
         	});
         
         });
      </script>
      <!-- //here ends scrolling icon -->
      <!--bootstrap working-->
      <script src="js/bootstrap.min.js"></script>
      <!-- //bootstrap working-->
