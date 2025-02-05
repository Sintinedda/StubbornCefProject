function editImg(input, img, label) {
    document.getElementById(input).style.display = 'block';
    document.getElementById(img).style.display = 'none';
    document.getElementById(label).textContent = "Ajouter une image";
    document.getElementById(label).style.padding = '5px 10px';
}

function addImg() {
    document.getElementById('sweat_img').style.display = 'block';
}

window.addEventListener('DOMContentLoaded', () => {
    const label = document.getElementById('form-add-img');
    if (label) {
        label.addEventListener('click', addImg, false);
    }
})