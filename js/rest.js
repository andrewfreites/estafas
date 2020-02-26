window.onload = updateClock;
let totalTime = 15*60;
function updateClock() {
  if (totalTime<20){
    document.getElementById('countdown').innerHTML = `Ya quedan solo: ${totalTime} segundos antes de cerrar la sesión`;
  }
  totalTime-=1;
  setTimeout("updateClock()",1000);
}