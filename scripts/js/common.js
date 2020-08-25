$(document).ready(function() {
  $(".cross").click(function() {
    $(".errors").slideUp();
    
  });
  
  if($(".errors").children("p")){
    console.log("HAS");
    $(".errors").slideDown("fast");
    $(".cross").css("display","block");
  }else{
    $(".errors").css("display","none");
  }
});

