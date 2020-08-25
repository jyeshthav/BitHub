$(document).ready(function () {
  $("#myInput").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".post-holder").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  
  $(".follow-btn").click(function() {
    var data = {};
    data['fid'] = $(this).attr("id").replace("follow","");
    data['numfollers'] = $(".numfollowers").children("span").html();
    data['type'] = $(this).attr("data-fol");
    if(data['type'] == "follow"){
      $.post(
        "scripts/php/follow-user.php",
        data,
        function(rdata){
          rdata = JSON.parse(rdata);
          if(rdata['return'] == true){
            $(".numfollowers").children("span").html(rdata["numfollers"]);
            $(this).attr("data-fol","followed");
            console.log($(this).attr("data-fol"));
//            alert("UNFOLLOW");
            showFollow();
          }          
        }
      );  
    }
    else if(data['type'] == "followed"){
      $.post(
        "scripts/php/follow-user.php",
        data,
        function(rdata){
          rdata = JSON.parse(rdata);
          if(rdata['return'] == true){
            $(".numfollowers").children("span").html(rdata["numfollers"]);
            $(this).attr("data-fol","followed");
            console.log($(this).attr("data-fol"));
//            alert("FOLLOW");
            showFollow();
          }
        }
      );
    }
  });
  
  function showFollow(){
    if($(".follow-btn").attr("data-fol") == "followed"){
      if($(".follow-btn").hasClass("follow")){
        $(".follow-btn").removeClass("follow");  
      }
      $(".follow-btn").addClass("unfollow");
      $(".follow-btn").html("Following");
      console.log($(".follow-btn").html());
    }else if($(".follow-btn").attr("data-fol") == "follow"){
      if($(".follow-btn").hasClass("unfollow")){
        $(".follow-btn").removeClass("unfollow");  
      }
      $(".follow-btn").addClass("follow");
      $(".follow-btn").html("Follow");
      console.log($(".follow-btn").html());
    }
    
  }
  showFollow();
});
