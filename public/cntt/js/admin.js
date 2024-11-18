document.querySelectorAll('.subCate input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            this.closest('li').classList.add('selected');
        } else {
            this.closest('li').classList.remove('selected');
        }
    });
});
