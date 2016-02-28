// detect the user's inactivity
// 
var IDLE_TIMEOUT = 10; // 2-min of inactivity
var _idleSecondsCounter = 0;
var base_url = document.getElementByTagName('base');
document.onclick = function() {
    _idleSecondsCounter = 0;
};
document.onmousemove = function() {
    _idleSecondsCounter = 0;
};
document.onkeypress = function() {
    _idleSecondsCounter = 0;
};
window.setInterval(CheckIdleTime, 1000);

function CheckIdleTime() {
    _idleSecondsCounter++;
    var oPanel = document.getElementById("SecondsUntilExpire");
    if (oPanel)
        oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
    if (_idleSecondsCounter >= IDLE_TIMEOUT) {
     //   alert("Time expired!");
        document.location.href = "<?php print base_url('auth/session/logout') ?>";
    }
}