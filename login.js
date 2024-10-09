document.getElementById('adminBtn').addEventListener('click', () => {
    document.getElementById('adminForm').classList.remove('hidden');
    document.getElementById('studentForm').classList.add('hidden');
});

document.getElementById('studentBtn').addEventListener('click', () => {
    document.getElementById('studentForm').classList.remove('hidden');
    document.getElementById('adminForm').classList.add('hidden');
});