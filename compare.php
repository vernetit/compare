<html>
<head>
  <meta charset="utf-8">
  <title>Compare 3d - Train your focus!</title>

    <link rel="icon" href="favicon.jpg" type="image/jpg"/>
    <link rel="shortcut icon" href="favicon.jpg" type="image/jpg" />
    
    <meta name="description" content="Train your focus">
    <meta name="keywords" content="brain training, focus, mental training, atention"> 

  <script src='js/jquery.min.js'></script>   
  <script src="js/underscore-min.js"></script>
  <script src="js/aframe-master.min.js"></script>
  <script src="js/nogyro.js"></script>
  <style type="text/css">
    body{
      background-color: black;
      color: green;
    }

    #footer {
            position:fixed;
            bottom:0;
            background-color: gray;
        }
  </style>

  <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-45359665-3', 'auto');
      ga('send', 'pageview');

    </script>
</head>
<body>
<div id="control">
<input type="button" value="start" onclick="play(0);" style="/*display:none;*/">
velocity
<select id="myVel" onchange="" style="">
</select>
difference
<select id="myDif" onchange="" style="">      
</select>
<span id="separation-div">
separation
<select id="separation" onchange="" style="">   
</select>
</span>

<script type="text/javascript">

for(i=1;i<240;i++){
  sel=""; selDif=""; sepSel="";
  
  if(i==5) sel="selected";
  $("#myVel").append(`<option value="${i}" ${sel}>${i}</option>`)
  
  if(i==1) selDif="selected";
  
  if(i<20) $("#myDif").append(`<option value="${i}" ${selDif}>${i}</option>`)

  if(i==4) sepSel="selected";

  if(i<16) $("#separation").append(`<option value="${i}" ${sepSel}>${i}</option>`)

}  

</script>
<select id="typeVel" onchange="" style="">   
  <option value="1" selected>adaptative velocity</option>
  <option value="2">fixed velocity</option>
</select>
<span onclick="$(this).hide();">
<b>&nbsp;What sphere flash at more speed? left or right. <span class="hide-mobile">Use arrow keys to answer.</span></b>
</span>
<a href="#" onclick="alert('License: GNU General Public License v3.0\nThis App is experimental and may contain errors\n https://github.com/vernetit/compare \n robertchalean@gmail.com - 2020')" style="float:right; color: green;">[?]</a>
<div id="stats" style="float:right;"></div>
</div>
<br>
<a-scene id="myScene" onclick="return;" style="z-index: 100;"> 


</a-scene>

<div id="footer" style="height: 120px; width:100%; z-index: 101;">
<div style="float: left; width: 50%; height: 50px; font-size: 40px;" id="footer-l"><center><br>&larr;</center></div>
<div style="float: left; width: 50%; height: 50px; font-size: 40px;" id="footer-r"><center><br>&rarr;</center></div>
  
</div>

<script type="text/javascript">

t_ini = 0;
t_fin = 0;
t_dif = 0;
t_total = 0;
t_promedio = 0;

miVelocity=10;
currentVelocity=20;
arrayElement=[];
diferencia=1;

arrKillIntermitent=[];
arrColorIntermitent=[];

multiplicador=1;
sentido=0;
error=0;
ok=0;
pasadas=0;
typeVel=1;

separation=1;

iniDif=0;

initY=3;

function play(x){

  if(x==0){

    $("#stats").html("");

    arrayElement=[];
    error=0;
    ok=0;
    pasadas=0;
    

    currentVelocity=parseInt($("#myVel").val());
    typeVel=parseInt($("#typeVel").val());
    iniDif=parseInt($("#myDif").val());

    if( (currentVelocity-iniDif)<3 ) iniDif=1;


    diferencia=iniDif;

    t_ini = 0;
    t_fin = 0;
    t_dif = 0;
    t_total = 0;
    t_promedio = 0;

    actualiza();

  }

  palabra=[];

  sentido=_.random(0,1)

  if(currentVelocity<=1) currentVelocity=2; 

  if(sentido){
    palabra[0]=currentVelocity;
    palabra[1]=currentVelocity-diferencia;
  }else{
    palabra[0]=currentVelocity-diferencia;
    palabra[1]=currentVelocity;

  }

    for(i=0;i<arrKillIntermitent.length;i++){

      clearInterval(arrKillIntermitent[i]);
    }

    arrKillIntermitent=[];
    arrColorIntermitent=[];

    for(i=0;i<100;i++){

      $(`#sp-${i}`).remove();
      $(`#sp-1-${i}`).remove();
      $(`.myNewTxt`).remove();

    }

    separation=parseInt( $("#separation").val() );
    console.log(separation)

    xCircle=0-(separation-1)*0.5;
    yCircle=initY;
    zCircle=-5;
    circleColor="blue";

    for(i=0;i<palabra.length;i++){
      arrColorIntermitent[i]=1;

      $("#myScene").append(`

        <a-sphere position="${xCircle+" "+yCircle+" "+zCircle}"  material="color: ${circleColor}"  radius="0.4" id="sp-${i}"></a-sphere>  
      `);

     

      xCircle+=( 1 + 1 * (separation-1)  );

      ev=`

         arrKillIntermitent[${i}]=setInterval(function(){

          if(arrColorIntermitent[${i}]){

            $("#sp-${i}").attr("material","color: blue");

          }else{
            $("#sp-${i}").attr("material","color: green");

          }

          arrColorIntermitent[${i}]=!arrColorIntermitent[${i}];          


          },1000/${palabra[i]+1} );


      `;

      eval(ev);
       
    }

    t_ini = Date.now();
    pasadas++;
}

function actualiza(){

  $("#stats").html(`
    c:${pasadas}&nbsp;|&nbsp;
    ok:${ok}&nbsp;|&nbsp;
    error:${error}&nbsp;|&nbsp;
    v:${currentVelocity}&nbsp;|&nbsp;
    d:${diferencia}&nbsp;|&nbsp;
    t:${t_promedio}&nbsp;
  `);
}

function flash(color){
  $("body").css("background-color",color);
  setTimeout(function(){ $("body").css("background-color","black"); },200);
}


$(document).keydown(function(e) {
  //console.log(e.which); 

    switch(e.which) {

        case 106:
          

        break;

        case 107:
          
            break;

        case 37: // left

            t_fin = Date.now();
            t_dif = t_fin - t_ini;
            t_total += t_dif
            t_promedio = Math.round(t_total/pasadas);

          if(sentido){
            ok++;

            if(diferencia==iniDif){
              if(typeVel==1/* && diferencia<=iniDif*/) currentVelocity++;
            
            }

            if(diferencia>iniDif) diferencia--;
            
             
            flash("green");
          }else{
            error++;
            if(typeVel==1 && (currentVelocity-diferencia)>1 ) diferencia++;
            if(error%3==0 && error!=0){
              if(typeVel==1  && currentVelocity>2) currentVelocity--;
            } 
            flash("red");
          }

          actualiza();
          play(1);
       
        break;

         case 65: // left
         
          
        break;

        case 38: // up
          
        break;

        case 87: // up
          
        break;

        case 39: // right

         t_fin = Date.now();
         t_dif = t_fin - t_ini;
         t_total += t_dif
         t_promedio = Math.round(t_total/pasadas);

         if(sentido){
            error++;
            if(typeVel==1 && (currentVelocity-diferencia)>1 ) diferencia++;
            if(error%3==0 && error!=0){
              if(typeVel==1 && currentVelocity>2) currentVelocity--;
            } 
              
            flash("red");
          }else{
            ok++;

            if(diferencia==iniDif)
            {
              if(typeVel==1 /*&& diferencia<=iniDif*/) currentVelocity++;
            } 

            if(diferencia>iniDif) diferencia--;
            
            flash("green");
          }

          actualiza();
          play(1);

          
        break;

        case 68: // right
        
        break;

        case 40: // down
          
        break;

        case 83: // down
       
          
        break;

        default: return; // exit this handler for other keys


    }

    //e.preventDefault(); // prevent the default action (scroll / move caret)
});

$("#footer-l").click(function(){
   t_fin = Date.now();
            t_dif = t_fin - t_ini;
            t_total += t_dif
            t_promedio = Math.round(t_total/pasadas);

          if(sentido){
            ok++;

            if(diferencia==iniDif){
              if(typeVel==1/* && diferencia<=iniDif*/) currentVelocity++;
            
            } 

            if(diferencia>iniDif) diferencia--;
            
            flash("green");
          }else{
            error++;
            if(typeVel==1 && (currentVelocity-diferencia)>1 ) diferencia++;
            if(error%3==0 && error!=0){
              if(typeVel==1  && currentVelocity>2) currentVelocity--;
            } 
            flash("red");
          }

          actualiza();
          play(1);
  

});

$("#footer-r").click(function(){

     t_fin = Date.now();
         t_dif = t_fin - t_ini;
         t_total += t_dif
         t_promedio = Math.round(t_total/pasadas);

         if(sentido){
            error++;
            if(typeVel==1 && (currentVelocity-diferencia)>1 ) diferencia++;
            if(error%3==0 && error!=0){
              if(typeVel==1 && currentVelocity>2) currentVelocity--;
            } 
              
            flash("red");
          }else{
            ok++;

            if(diferencia==iniDif)
            {
              if(typeVel==1 /*&& diferencia<=iniDif*/) currentVelocity++;
            } 

            if(diferencia>iniDif) diferencia--;
            
            
            flash("green");
          }

          actualiza();
          play(1);
  

});

function detectmob() { 
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}

$("#footer").hide();

if(detectmob()){
  $("#separation").val("1");
  console.log("show")
  initY=3;
  $("#footer").show();
  $(".hide-mobile").hide();
  $("#separation-div").hide();
  $("#control, #stats").css("background-color","gray");
  $("#control, #stats").css("color","black");
  $("#myScene").append(`
        <a-entity camera touch-controls></a-entity>

    `);
}

 setTimeout(function(){ alert("go out to the park!")  },6*60*1000);  



</script>

</body>
</html>