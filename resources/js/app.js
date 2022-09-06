require('./bootstrap');

console.log("dsadasdas");


document.addEventListener('keydown',(evt) => {
    if (evt.keyCode === 37 && evt.altKey) {
        // Stop browser action
        evt.preventDefault();
        // Do something here
        console.log('ALT + Left Arrow Pressed');
        // ...
    }
});
