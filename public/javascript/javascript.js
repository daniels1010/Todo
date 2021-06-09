var allCheckbox = document.getElementsByClassName("card-checkbox");

console.log(allCheckbox);

[...allCheckbox].forEach(card => {
    card.addEventListener('change', function(){
        toggleCardCheckbox(card);
    });
});


function toggleCardCheckbox(card) {
    card.disabled = true;
    cardId = card.value;
    axios.post(rootUrl + '/todo/toggleCheckbox/' + cardId, {
        id: cardId
    }).then(function(){
        card.disabled = false;
    })
} 