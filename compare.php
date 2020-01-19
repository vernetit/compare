<html>
<head>
  <meta charset="utf-8">
  <title>compare 3d</title>
  <script src='js/jquery.min.js'></script>   
  <script src="js/underscore-min.js"></script>
  <script src="js/aframe-master.min.js"></script>
  <style type="text/css">
    body{
      background-color: black;
      color: green;
    }
      <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-45359665-3', 'auto');
      ga('send', 'pageview');

    </script>
  </style>
</head>
<body>
<input type="button" value="start" onclick="play(0);" style="/*display:none;*/">
velocity
<select id="myVel" onchange="" style="">   
</select>

<script type="text/javascript">

for(i=1;i<150;i++){
  sel="";
  if(i==5) sel="selected";
  $("#myVel").append(`<option value="${i}" ${sel}>${i}</option>`)

}  

</script>
<select id="typeVel" onchange="" style="">   
  <option value="1" selected>adaptative velocity</option>
  <option value="2">fixed velocity</option>
</select>
<b>What sphere flash at more speed left or right? Use arrow keys to answer. (App for desktop Pc)</b>
<a href="#" onclick="alert('This App is experimental and may contain errors\n robertchalean@gmail.com 2020')" style="float:right;">[?]</a>
<div id="stats" style="float:right;"></div>
<br>
<a-scene id="myScene" onclick="" style="z-index: 100;"> </a-scene>

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

function play(x){

  if(x==0){

    arrayElement=[];
    error=0;
    ok=0;
    pasadas=0;

    currentVelocity=parseInt($("#myVel").val());
    
    typeVel=parseInt($("#typeVel").val());

    t_ini = 0;
    t_fin = 0;
    t_dif = 0;
    t_total = 0;
    t_promedio = 0;

  }

  palabra=[];

  sentido=_.random(0,1)

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

    xCircle=-3;
    yCircle=3;
    zCircle=-5;
    circleColor="blue";

    for(i=0;i<palabra.length;i++){
      arrColorIntermitent[i]=1;

      $("#myScene").append(`

        <a-sphere position="${xCircle+" "+yCircle+" "+zCircle}"  material="color: ${circleColor}"  radius="0.4" id="sp-${i}"></a-sphere>  
      `);

      xCircle+=1;

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
    t:${t_promedio}
  `);
}

function flash(color){
  $("body").css("background-color",color);
  setTimeout(function(){ $("body").css("background-color","black"); },200);
}


$(document).keydown(function(e) {
  console.log(e.which); 

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
            diferencia=1;
            if(ok%3==0 && ok!=0){  
              if(typeVel==1) currentVelocity++;
            } 
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
            diferencia=1;
            if(ok%3==0 && ok!=0)
            {
              if(typeVel==1) currentVelocity++;
            } 
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


</script>

</body>
</html>