function saveInput(id) {
    var value = document.getElementById(id).value;
    try {
        localStorage.setItem(id, value);
    } catch (e) {
        console.error('Error saving to localStorage', e);
    }
}

function loadInput(id) {
    try {
        var value = localStorage.getItem(id);
        if (value) {
            document.getElementById(id).value = value;
        }
    } catch (e) {
        console.error('Error loading from localStorage', e);
    }
}

function setupInputListeners() {
    var inputs = ['email', 'password', 'age','name'];
    inputs.forEach(function(id) {
        document.getElementById(id).addEventListener('input', function() {
            saveInput(id);
        });
    });
}

window.onload = function() {
    // Load saved inputs
    loadInput('age');
    loadInput('name');
    loadInput('email');
    loadInput('password');

    // Setup input listeners
    setupInputListeners();
};
