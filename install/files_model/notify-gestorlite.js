loadcss();
function loadcss(){
 var head   = document.getElementsByTagName('head')[0];
 var css    = document.createElement('link');
 css.rel    = 'stylesheet';
 css.type   = 'text/css';
 css.href   = 'https://{dominio}/notify-gestor/notify-gestorlite.css?v=4';
 css.media = 'all';
 head.appendChild(css);
}

intervalTime = 25000;

notifyLoop = setInterval(function(){

if(typeof memberidGl == "undefined"){
  console.log('Notify Gestor Master: memberidGl undefined');
  clearInterval(notifyLoop);
  return false;
}

var url = 'https://{dominio}/notify-gestor/get.php?member='+memberidGl;
var xhttp = new XMLHttpRequest();
xhttp.open("GET", url, false);
xhttp.send();
response = xhttp.responseText;

if(response){

  if(response == 'inactive'){
    clearInterval(notifyLoop);
    return false;
  }

  var obj = JSON.parse(response);
  if(typeof positionNotifyGl == "undefined"){
    positionNotifyGl = 'bottom';
  }
  notify_gestor(obj.nome,obj.produto,obj.bussines,positionNotifyGl,obj.time);
}
},intervalTime);


function notify_gestor(cliente,produto,bussines,position,time){
var html_notify = '<div class="notify-gestor-'+position+' notify-gestor-container" id="notify-gestor-lite-div" ><div class="notify-gestor-body"><div class="notify-col-4"><img src="https://{dominio}/notify-gestor/icon-128x128.gif" alt=""></div><div class="notify-col-8"><div class="notify-gestor-title">';
html_notify += '<span>'+bussines+'</span>';
html_notify += '</div><div class="notify-gestor-subtitle">'+cliente+' comprou <span class="notify-gestor-produto-name" >'+produto+'</span>';
html_notify += '</div></div></div><div class="notify-gestor-footer"><a class="notify-gestor-link-copyright" href="https://{dominio}" target="_blank">';
html_notify += '<span class="notify-gestor-copyright"><span class="notify-gestor-time">'+time+'</span><svg width="12" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;top: 2px;position: relative;margin-right: 2px;" xml:space="preserve"><style type="text/css">.st0{fill:#6927ff;}</style><g id="_x3C_Group_x3E_"><path  class="st0" d="M512,268c0,17.9 4.3,34.5-12.9,49.7c-8.6,15.2-20.1,27.1-34.6,35.4c0.4,2.7,0.6,6.9,0.6,12.6 c0,27.1-9.1,50.1-27.1,69.1c-18.1,19.1-39.9,28.6-65.4,28.6c-11.4,0-22.3-2.1-32.6-6.3c-8,16.4-19.5,29.6-34.6,39.7 C290.4,507,273.9,512,256,512c-18.3,0-34.9-4.9-49.7-14.9c-14.9-9.9-26.3-23.2-34.3-40c-10.3,4.2-21.1,6.3-32.6,6.3 c-25.5,0-47.4-9.5-65.7-28.6c-18.3-19-27.4-42.1-27.4-69.1c0-3,0.4-7.2,1.1-12.6c-14.5-8.4-26-20.2-34.6-35.4 C4.3,302.5,0,285.9,0,268c0-19,4.8-36.5,14.3-52.3c9.5-15.8,22.3-27.5,38.3-35.1c-4.2 11.4-6.3-22.9-6.3-34.3 c0-27,9.1-50.1,27.4-69.1c18.3-19,40.2-28.6,65.7-28.6c11.4,0,22.3,2.1,32.6,6.3c8-16.4,19.5-29.6,34.6-39.7 C221.6,5.1,238.1,0,256,0c17.9,0,34.4,5.1,49.4,15.1c15,10.1,26.6,23.3,34.6,39.7c10.3-4.2,21.1-6.3,32.6-6.3 c25.5,0,47.3,9.5,65.4,28.6c18.1,19.1,27.1,42.1,27.1,69.1c0,12.6-1.9,24-5.7,34.3c16,7.6,28.8,19.3,38.3,35.1 C507.2,231.5,512,249,512,268z M245.1,345.1l105.7-158.3c2.7-4.2,3.5-8.8,2.6-13.7c-1-4.9-3.5-8.8-7.7-11.4 c-4.2-2.7-8.8-3.6-13.7-2.9c-5,0.8-9,3.2 12,7.4l-93.1,140L184,263.4c-3.8-3.8-8.2-5.6-13.1-5.4c-5,0.2-9.3,2-13.1,5.4 c-3.4,3.4-5.1,7.7 5.1,12.9c0,5.1,1.7,9.4,5.1,12.9l58.9,58.9l2.9,2.3c3.4,2.3,6.9,3.4,10.3,3.4 C236.6,353.7,241.7,350.9,245.1,345.1z"/> </g><span class="notify-gestor-copyright-name">by Gestor Master</span></span></a></div></div>';
 document.body.insertAdjacentHTML('afterend', html_notify);
 setTimeout(function(){document.getElementById("notify-gestor-lite-div").remove();},10000);
}