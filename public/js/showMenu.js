function showMenu(id, btn) {
    if (document.getElementById(id).style.display == 'block') {
        document.getElementById(id).style.display = 'none';
        document.getElementById(btn).style.color = 'black';
    } else {
        document.getElementById(id).style.display = 'block';
        document.getElementById(btn).style.color = 'grey';
    }
}

function onResize() {
    if (document.documentElement.clientWidth > 767) {
        document.getElementById('menu').style.display = 'flex';
    }  else if (document.documentElement.clientWidth < 768 &&
        document.getElementById('menu').style.display == 'flex'
    ) {
        document.getElementById('menu').style.display = 'none';
        document.getElementById('menu-btn').style.color = 'black';
    } else {
    }
}

window.addEventListener('resize', onResize);