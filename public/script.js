function showSection(sectionID) {
    document.getElementById('home').style.display = 'none';
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    const active = document.getElementById(sectionID);
    if(active) active.style.display = 'block';
}

function hideAllContent() {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'block';
}

function clearFields() {
    document.querySelectorAll('.field').forEach(input => input.value = '');
}

window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    const status = params.get('status');

    // Handle Alerts
    if (status === 'success') {
        alert("Added Successfully");
        showSection('create');
    } else if (status === 'updated') {
        alert("Update Successfully");
        showSection('update');
    } else if (status === 'deleted') {
        alert("Deleted Successfully");
        showSection('delete');
    } 
    // Handle Search persistence
    else if (params.has('search_u')) {
        showSection('update');
    } else if (params.has('search_d')) {
        showSection('delete');
    } else {
        hideAllContent();
    }
}
