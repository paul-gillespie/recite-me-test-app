
var elements    = document.getElementsByClassName("feed-item");

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click',(evt) => {
        if (evt.altKey) {
            evt.preventDefault();

            var button = evt.currentTarget.getElementsByClassName("feed-btn");

            button[0].style.display = "block";
        }
        else {
            var buttons = document.getElementsByClassName("feed-btn");

            for(i = 0; i < buttons.length; i++) {
                buttons[i].style.display = "none";
            }
        }
    });
}
