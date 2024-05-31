// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Load files from localStorage on page load
    loadFilesFromLocalStorage();
});

document.getElementById('upload-button').addEventListener('click', function() {
    const fileInput = document.getElementById('file-input');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        addFileToList(file);
        saveFileToLocalStorage(file);
        fileInput.value = ''; // Clear the input
    }
});

function addFileToList(file) {
    const fileList = document.getElementById('file-list');

    const listItem = document.createElement('li');
    listItem.className = 'file-item';

    const fileName = document.createElement('span');
    fileName.textContent = file.name;
    fileName.className = 'file-name';

    const changeButton = document.createElement('button');
    changeButton.className = 'change-button';
    changeButton.textContent = 'Cambiar';
    changeButton.addEventListener('click', function() {
        // Change file logic here
        const newFileInput = document.createElement('input');
        newFileInput.type = 'file';
        newFileInput.addEventListener('change', function() {
            if (newFileInput.files.length > 0) {
                const newFile = newFileInput.files[0];
                fileName.textContent = newFile.name;
                updateFileInLocalStorage(file.name, newFile);
                file.name = newFile.name; // Update the file name in the list item
            }
        });
        newFileInput.click();
    });

    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete-button';
    deleteButton.textContent = 'Borrar';
    deleteButton.addEventListener('click', function() {
        fileList.removeChild(listItem);
        removeFileFromLocalStorage(file.name);
    });

    const sendButton = document.createElement('button');
    sendButton.className = 'send-button';
    sendButton.textContent = 'Enviar';
    sendButton.addEventListener('click', function() {
        // Send file logic here
        alert('Archivo "' + file.name + '" enviado.');
    });

    listItem.appendChild(fileName);
    listItem.appendChild(changeButton);
    listItem.appendChild(deleteButton);
    listItem.appendChild(sendButton);

    fileList.appendChild(listItem);
}

function saveFileToLocalStorage(file) {
    let files = JSON.parse(localStorage.getItem('files')) || [];
    files.push(file.name);
    localStorage.setItem('files', JSON.stringify(files));
}

function loadFilesFromLocalStorage() {
    const files = JSON.parse(localStorage.getItem('files')) || [];
    files.forEach(fileName => {
        const file = { name: fileName };
        addFileToList(file);
    });
}

function removeFileFromLocalStorage(fileName) {
    let files = JSON.parse(localStorage.getItem('files')) || [];
    files = files.filter(name => name !== fileName);
    localStorage.setItem('files', JSON.stringify(files));
}

function updateFileInLocalStorage(oldFileName, newFile) {
    let files = JSON.parse(localStorage.getItem('files')) || [];
    const index = files.indexOf(oldFileName);
    if (index > -1) {
        files[index] = newFile.name;
        localStorage.setItem('files', JSON.stringify(files));
    }
}