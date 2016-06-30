var adv=document.getElementById('adv');

var x=0;
var y=0;
var vx = 8;
var vy = 5;
var cwidth = window.innerWidth;
var cheight = window.innerHeight;
var tid=setInterval(change, 30);

adv.addEventListener('mouseover',advmouseover,false);
adv.addEventListener('mouseout',advmouseout,false);

function advmouseover() {
    clearInterval(tid);
}
function advmouseout() {
    tid=setInterval(change, 30);
}

function change() {
    x+=vx;
    y+=vy;
    if (x+300>=cwidth || x<=0) {
        vx=-vx;
    }
    if (y+200>=cheight || y<=0) {
        vy=-vy;
    }

    adv.style.top=y+"px";
    adv.style.left=x+"px";
}

function closeadv() {
    adv.style.display='none';
}
