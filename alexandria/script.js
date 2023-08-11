// Search by tag
document.addEventListener('DOMContentLoaded', function() {
    var tagSearch = document.getElementById('tagSearch');
    var comicTags = document.getElementsByClassName('comic-tags');
    
    tagSearch.addEventListener('input', function() {
        var searchQuery = tagSearch.value.toLowerCase();
        
        for (var i = 0; i < comicTags.length; i++) {
            var comicTag = comicTags[i];
            var tagText = comicTag.textContent.toLowerCase();
            
            if (tagText.includes(searchQuery)) {
                comicTag.parentNode.style.display = 'table-row';
            } else {
                comicTag.parentNode.style.display = 'none';
            }
        }
    });
});


// Search by team
document.addEventListener('DOMContentLoaded', function() {
    var teamSearch = document.getElementById('teamSearch');
    var teamTags = document.getElementsByClassName('comic-team');
    
    teamSearch.addEventListener('input', function() {
        var searchQuery = teamSearch.value.toLowerCase();
        
        for (var i = 0; i < teamTags.length; i++) {
            var teamTag = teamTags[i];
            var tagText = teamTag.textContent.toLowerCase();
            
            if (tagText.includes(searchQuery)) {
                teamTag.parentNode.style.display = 'table-row';
            } else {
                teamTag.parentNode.style.display = 'none';
            }
        }
    });
});



// Sort by rating on header click
document.addEventListener('DOMContentLoaded', function() {
    var ratingHeader = document.getElementById('ratingHeader');
    var ratingCells = document.getElementsByClassName('comic-rating');
    
    ratingHeader.addEventListener('click', function() {
        // Convert HTMLCollection to array for easier sorting
        var cellsArray = Array.from(ratingCells);
        
        // Sort the cells based on the rating
        cellsArray.sort(function(cell1, cell2) {
            var rating1 = parseInt(cell1.textContent);
            var rating2 = parseInt(cell2.textContent);
            
            return rating2 - rating1; // Descending order
        });
        
        // Remove existing rows from the table
        var tbody = document.querySelector('tbody');
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        
        // Append the sorted rows back to the table
        cellsArray.forEach(function(cell) {
            tbody.appendChild(cell.parentNode);
        });
    });
});

// Sort by team on header click
document.addEventListener('DOMContentLoaded', function() {
    var teamHeader = document.getElementById('teamHeader');
    var teamCells = document.getElementsByClassName('comic-team');
    
    teamHeader.addEventListener('click', function() {
        sortTableByTeam();
    });
});

function sortTableByTeam() {
    var teamCells = document.getElementsByClassName('comic-team');
    
    // Convert HTMLCollection to array for easier sorting
    var cellsArray = Array.from(teamCells);
    
    // Sort the cells based on the team name
    cellsArray.sort(function(cell1, cell2) {
        var team1 = cell1.textContent.toLowerCase();
        var team2 = cell2.textContent.toLowerCase();
        
        if (team1 < team2) {
            return -1;
        } else if (team1 > team2) {
            return 1;
        } else {
            return 0;
        }
    });
    
    // Remove existing rows from the table
    var tbody = document.querySelector('tbody');
    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }
    
    // Append the sorted rows back to the table
    cellsArray.forEach(function(cell) {
        tbody.appendChild(cell.parentNode);
    });
}




// Update the table



// Get the form element
var addForm = document.getElementById('addForm');

// Add an event listener for the form submit event
addForm.addEventListener('submit', function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    
    // Get the values of the form fields
    var comicTitle = addForm.elements['comicTitle'].value;
    var comicTeam = addForm.elements['comicTeam'].value;
    var comicRating = addForm.elements['comicRating'].value;
    var comicTags = addForm.elements['comicTags'].value;
    var comicChapter = addForm.elements['comicChapter'].value;
    var comicLink = addForm.elements['comicLink'].value;
    var readDate = addForm.elements['lastRead'].value;
    
    // Send the form data to the server using the fetch() method
    fetch('add_comic.php', {
        method: 'POST',
        body: new FormData(addForm)
    })
    .then(response => response.text())
    .then(data => {
        // Create a new row in the table with the form data
        var table = document.getElementById('readingList');
        var newRow = table.insertRow(-1);
        var titleCell = newRow.insertCell(0);
        var teamCell = newRow.insertCell(1);
        var ratingCell = newRow.insertCell(2);
        var tagsCell = newRow.insertCell(3);
        var chapterCell = newRow.insertCell(4);
        var readCell = newRow.insertCell(5);
        titleCell.innerHTML = '<a href="' + comicLink + '">' + comicTitle + '</a>';
        teamCell.innerHTML = comicTeam;
        ratingCell.innerHTML = comicRating;
        tagsCell.innerHTML = comicTags;
        chapterCell.innerHTML = '<span contenteditable="true">' + comicChapter + '</span>';
        readCell.innerHTML = readDate;
        
        // Reset the form
        addForm.reset();
    })
    .catch(error => console.error(error));
});





// Define a function to fetch the database content and update the table
function updateTable() {
    fetch('add_comic.php')
    .then(response => response.text())
    .then(data => {
        // Update the table with the database content
        var table = document.getElementById('readingList');
        table.innerHTML = data;
    })
    .catch(error => console.error(error));
}

// Call the updateTable() function when the page is loaded
window.addEventListener('load', updateTable);

// Add an event listener for the form submit event
addForm.addEventListener('submit', function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    
    // Get the values of the form fields
    var comicTitle = addForm.elements['comicTitle'].value;
    var comicTeam = addForm.elements['comicTeam'].value;
    var comicRating = addForm.elements['comicRating'].value;
    var comicTags = addForm.elements['comicTags'].value;
    var comicChapter = addForm.elements['comicChapter'].value;
    var comicLink = addForm.elements['comicLink'].value;
    var readDate = addForm.elements['lastRead'].value;
    
    // Validate the form data
    if (comicTitle === '' || comicTeam === '' || comicRating === '' || comicTags === '' || comicChapter === '' || comicLink === '' || readDate === '') {
        alert('Please fill in all the required fields');
        return;
    }
    
    // Send the form data to the server using the fetch() method
    fetch('add_comic.php', {
        method: 'POST',
        body: new FormData(addForm)
    })
    .then(response => response.text())
    .then(data => {
        // Check if the form data was successfully added to the database
        if (data === 'success') {
            // Create a new row in the table with the form data
            var table = document.getElementById('readingList');
            var newRow = table.insertRow(-1);
            var titleCell = newRow.insertCell(0);
            var teamCell = newRow.insertCell(1);
            var ratingCell = newRow.insertCell(2);
            var tagsCell = newRow.insertCell(3);
            var chapterCell = newRow.insertCell(4);
            var readCell = newRow.insertCell(5);
            titleCell.innerHTML = '<a href="' + comicLink + '">' + comicTitle + '</a>';
            teamCell.innerHTML = comicTeam;
            ratingCell.innerHTML = comicRating;
            tagsCell.innerHTML = comicTags;
            chapterCell.innerHTML = '<span contenteditable="true">' + comicChapter + '</span>';
            readCell.innerHTML = readDate;
            
            // Reset the form
            addForm.reset();
            
            // Update the table with the new data
            updateTable();
        } else {
            // Display an error message
            alert('Error: ' + data);
        }
    })
    .catch(error => console.error(error));
});



