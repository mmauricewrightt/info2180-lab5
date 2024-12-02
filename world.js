document.addEventListener('DOMContentLoaded', function () {
    const countryLookupButton = document.getElementById('lookup');
    const cityLookupButton = document.getElementById('lookupCities'); 
    const resultDiv = document.getElementById('result'); 
    const countryInput = document.getElementById('country'); 
    

    function fetchData(url) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function () {
            if (xhr.status == 200) {
                resultDiv.innerHTML = xhr.responseText; 
                
            } else {
                resultDiv.textContent = 'Error fetching data.';
            }
        };

        xhr.onerror = function () {
            resultDiv.textContent = 'Request failed.';
        };

        xhr.send();
    }

   
    countryLookupButton.addEventListener('click', function (e) {
        e.preventDefault();
        const country = encodeURIComponent(countryInput.value.trim());
        const url = `world.php?country=${country}&city=false`;
        fetchData(url);
    });

    cityLookupButton.addEventListener('click', function (e) {
        e.preventDefault();
        const country = encodeURIComponent(countryInput.value.trim());
        const url = `world.php?country=${country}&city=true`;


        fetchData(url);
    });
});
