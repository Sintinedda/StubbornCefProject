function showMenu(id, btn) {
    if (document.getElementById(id).style.display == 'block') {
        document.getElementById(id).style.display = 'none';
        document.getElementById(btn).style.color = 'black';
    } else {
        document.getElementById(id).style.display = 'block';
        document.getElementById(btn).style.color = 'grey';
    }
}