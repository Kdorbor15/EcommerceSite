
  function showNav(){
    if(document.getElementById('navLinks').classList.contains('isActiveNav')){
      document.getElementById('navLinks').classList.remove('isActiveNav');
    }else{
      document.getElementById('navLinks').classList.add('isActiveNav');
    }
  }


function showLabel(){
  if(window.location.pathname.split("/").pop() == 'personalInfo.php'){
    document.getElementById("bottomNavLabel").innerHTML = "Personal Info"
    document.getElementById("infoPG").style.fontWeight = 600;
  }else if(window.location.pathname.split("/").pop() == 'orders.php'){
    document.getElementById("bottomNavLabel").innerHTML = "Orders";
    document.getElementById("orderPG").style.fontWeight = 600;
  }else{
    document.getElementById("bottomNavLabel").innerHTML = "My Account";
    document.getElementById("accountPG").style.fontWeight = 600;
  }
}


function toggleBottomNav() {
    var x = document.getElementById("bottomNavi");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
  
  
$(document).ready(function(){
    $("#showDefaultField").click(function(){
      $("#editInfo").hide(300);
      $("#defaultInfo").show(300);
    });
    $("#showEditField").click(function(){
      $("#editInfo").show(300);
      $("#defaultInfo").hide(300);
    });
  });

  $(document).ready(function(){
    $("#passToDefault").click(function(){
      $("#changePasswordDiv").hide(300);
      $("#defaultInfo").show(300);
    });
    $("#showPasswordField").click(function(){
      $("#changePasswordDiv").show(300);
      $("#defaultInfo").hide(300);
    });
  });


  $(document).ready(function(){
    $("#addAddressToDefault").click(function(){
      $("#addAddressDiv").hide(300);
      $("#defaultAddressDiv").show(300);
    });
    $("#defaultToAddAddress").click(function(){
      $("#addAddressDiv").show(300);
      $("#defaultAddressDiv").hide(300);
    });
  });

  // $(document).ready(function(){
  //   $("#editAddressToDefault").click(function(){
  //     $("#editAddressDiv").hide(300);
  //     $("#defaultAddressDiv").show(300);
  //   });
  //   $(".editAddressBTN").click(function(e){
  //     $("#editAddressDiv").show(300);
  //     $("#defaultAddressDiv").hide(300);
  //     e.prefentDefault();
  //   });
  // });
 


  $(document).ready(function(){
    $("#paymentToDefault").click(function(){
      $("#addPayment").hide();
      $("#defaultPayment").show();
    });
    $("#defaultToPayment").click(function(){
      $("#addPayment").show();
      $("#defaultPayment").hide();
    });
  });
  

  //checkout
  // add Address
  $(document).ready(function(){
    $("#DtoA").click(function(){
      $("#addShippingInfo").show();
      $('.addShippingInfo input').keyup(function() {
      
        var empty = false;
        $('.requiredInput').prop('required',true);
        $('.requiredInput').each(function() {
            if ($(this).val().length == 0) {
                empty = true;
            }
        });                   
    
        if (empty) {
            $('#AtoD').attr('disabled', 'disabled');
        } else {
            $('#AtoD').removeAttr('disabled');
        }
      });

      $("#defaultShippingInfo").hide();
    });
    $("#cancelAddy").click(function(){
      $("#addShippingInfo").hide();
      $("#defaultShippingInfo").show();
   });
   $('.requiredAttribute').removeAttr('required');
  });






  // continue to Payment Method BTN
  $(document).ready(function(){
    $("#DtoP").click(function(){
      $("#addPaymentInfo").show();
      $("#defaultPaymentInfo").hide();
    }); 
  });


    function getShippingPrice(){
      var price = $("input[name=rad]:checked").val();
      var k1 = document.getElementById("k1").innerHTML;
      document.getElementById("k2").innerHTML= price;
      var t3 = parseFloat(((parseFloat(k1)+parseFloat(price)) * .07));
      document.getElementById("k3").innerHTML = t3.toFixed(2);
      document.getElementById("k4").innerHTML = (parseFloat(price)+parseFloat(k1)+t3).toFixed(2);
      document.getElementById("k1").innerHTML = parseFloat(k1).toFixed(2);
    }


  $(document).ready(function(){
    $(document).on('change','.rad',function(){
      getShippingPrice();
 
    });
  });

  
  $(document).ready(function(){
    $("#toggleOrderSummary").click(function(){
      $("#mobileSummary").toggle();
    });
  });





  $(document).ready(function(){
    $("#registerButton").click(function(){
      $("#registerForm").show();
      $("#logInForm").hide();
    });
  });



