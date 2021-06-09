// Atrodd visus čekbokšus un katram pieliek eventListener, 
// lai nospiežot uz jebkura čekboksa tiks izsaukta funkcija un padot tieši tā čekboksa kartītes objekts
var allCheckbox = document.getElementsByClassName("card-checkbox");

[...allCheckbox].forEach(card => {
    card.addEventListener('change', function(){
        toggleCardCheckbox(card);
    });
});


function toggleCardCheckbox(card) {

    // Nobloķē čekbosi, kamēr apstrādā pieprasījumu (parasti attiecas uz lēniem/nestabiliem pieslēgumiem)
    card.disabled = true;
    
    // Padod id uz kontrolieri, kur apstrādās un izpildīs atjaunināšanu
    cardId = card.value;
    axios.post(rootUrl + '/todo/toggleCheckbox/' + cardId, {
        id: cardId
    }).then(function(){
        // pēc tam kad id padots serverim, atbloķē čekboksi
        card.disabled = false;
    });
} 