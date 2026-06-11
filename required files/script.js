const suggestions = document.getElementById("suggestions");
const input = document.getElementById("guess");

// TODO fetching data from search.php
input.addEventListener("input", function () {

    fetch("search.php?search=" + input.value)
        .then(response => response.text())
        .then(data => {

            suggestions.innerHTML = data;

        });

});


//TODO making suggestions clickable
suggestions.addEventListener("click", function (event) {

    if (event.target.classList.contains("suggestion")) {

        input.value = event.target.innerText;

        suggestions.innerHTML = "";

    }

});

