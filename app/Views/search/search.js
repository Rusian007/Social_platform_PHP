

const input =document.querySelector('#query');


document.getElementById('query').addEventListener('input', function() {
    var query = this.value;
    if (query === "" || query.length === 0) {
        // the string is empty
        var resultsContainer = document.getElementById('results');
        resultsContainer.innerHTML = '';

        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Parse the search results

            var results = JSON.parse(this.responseText);

            // Update the page with the search results
            var resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';
            for (var i = 0; i < results.length; i++) {
                var result = results[i];
                var resultElement = document.createElement('li');
                resultElement.setAttribute('data-post-id', result.post_id);
                resultElement.textContent = result.post_title;
                resultElement.onclick = function() {
                    var postId = this.dataset.postId;
                    window.location.href = 'http://localhost/start/search/showpost/?post_id=' + postId;
                };
                resultsContainer.appendChild(resultElement);
            }
        }
    };
    xhr.open('GET', 'http://localhost/start/search/search/?q=' + encodeURIComponent(query), true);
    xhr.send();
});


