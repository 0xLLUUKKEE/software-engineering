window.onload = function() {
    var modal = document.getElementById("myModal");
    var yesBtn = document.getElementById("yesBtn");
    var noBtn = document.getElementById("noBtn");

    // Display the modal
    modal.style.display = "block";

    // Handle the "Yes" button click
    yesBtn.onclick = function() {
        window.location.href = 'betpage.php';
    }

    // Handle the "No" button click
    noBtn.onclick = function() {
        modal.style.display = "none";
    }
}
