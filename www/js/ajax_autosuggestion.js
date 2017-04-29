/*
 * This script contains AJAX methods
 */
var xmlHttp;
var numUsers = 0;  //total number of suggested users 
var activeUser = -1;  //User currently being selected
var searchBoxObj, suggestionBoxObj;

//this function creates a XMLHttpRequest object. It should work with most types of browsers.
function createXmlHttpRequestObject() {
    // create a XMLHttpRequest object compatible to most browsers
    if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        alert("Error creating the XMLHttpRequest object.");
        return false;
    }
}

//initial actions to take when the page load
window.onload = function () {
    //create an XMLHttpRequest object by calling the createXmlHttpRequestObject function
    xmlHttp = createXmlHttpRequestObject();

    //DOM objects
    searchBoxObj = document.getElementById('searchtextbox');
    suggestionBoxObj = document.getElementById('suggestionDiv');
};

window.onclick = function () {
    suggestionBoxObj.style.display = "none";
};

//set and send XMLHttp request. The parameter is the search term
function suggest(query) {
    //if the search term is empty, clear the suggestion box.
    if (query === "") {
        suggestionBoxObj.innerHTML = "";
        return;
    }

    //proceed only if the search term isn't empty
    // open an asynchronous request to the server.
    xmlHttp.open("GET", base_url + "/" + type + "/suggest/" + query, true);

    //handle server's responses
    xmlHttp.onreadystatechange = function () {
        // proceed only if the transaction has completed and the transaction completed successfully
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            // extract the JSON received from the server
            var users = JSON.parse(xmlHttp.responseText);
            //console.log(usersJSON);
            // display suggested users in a div block
            displayUsers(users);
        }
    };

    // make the request
    xmlHttp.send(null);
}


/* This function populates the suggestion box with spans containing all the users
 * The parameter of the function is a JSON object
 * */
function displayUsers(users) {
    numUsers = users.length;
    //console.log(numUsers);
    activeUser = -1;
    if (numUsers === 0) {
        //hide all suggestions
        suggestionBoxObj.style.display = 'none';
        return false;
    }

    var divContent = "";
    //retrive the users from the JSON doc and create a new span for each user
    for (i = 0; i < users.length; i++) {
        divContent += "<br id=s_" + i + " onclick='clickUser(this)'>" + users[i] + "</br>";
    }
    //display the spans in the div block
    suggestionBoxObj.innerHTML = divContent;
    suggestionBoxObj.style.display = 'block';
}

//This function handles keyup event. The funcion is called for every keystroke.
function handleKeyUp(e) {
    // get the key event for different browsers
    e = (!e) ? window.event : e;

    /* if the keystroke is not up arrow or down arrow key, 
     * call the suggest function and pass the content of the search box
     */
    if (e.keyCode !== 38 && e.keyCode !== 40) {
        suggest(e.target.value);
        return;
    }

    //if the up arrow key is pressed
    if (e.keyCode === 38 && activeUser > 0) {
        //add code here to handle up arrow key. e.g. select the previous item
        activeUserObj.style.backgroundColor = "#FFF";
        activeUser--;
        activeUserObj = document.getElementById("s_" + activeUser);
        activeUserObj.style.backgroundColor = "#F5DEB3";
        searchBoxObj.value = activeUserObj.innerHTML;
        return;
    }

    //if the down arrow key is pressed
    if (e.keyCode === 40 && activeUser < numUsers - 1) {
        //add code here to handle down arrow key, e.g. select the next item 

        if (typeof (activeUserObj) != "undefined") {
            activeUserObj.style.backgroundColor = "#FFF";
        }
        activeUser++;
        activeUserObj = document.getElementById("s_" + activeUser);
        activeUserObj.style.backgroundColor = "#F5DEB3";
        searchBoxObj.value = activeUserObj.innerHTML;
    }
}



//when a user is clicked, fill the search box with the user and then hide the suggestion list
function clickUser(user) {
    //display the user in the search box
    searchBoxObj.value = user.innerHTML;

    //hide all suggestions
    suggestionBoxObj.style.display = 'none';
}
