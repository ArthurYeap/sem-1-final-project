const suggestions = document.getElementById("suggestions");
const input = document.getElementById("guess");
console.log("script loaded");
// TODO fetching data from search.php
input.addEventListener("input", function () {

    fetch("search.php?search=" + input.value)
        .then(response => response.text())
        .then(data => {

            // ! turning innerHTML of suggestions into character name
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
