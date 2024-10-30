document.getElementById('province-dropdown').addEventListener('change', function () {
    var provinceId = this.value;
    var amphureDropdown = document.getElementById('amphure-dropdown');
    var tambonDropdown = document.getElementById('tambon-dropdown');
    var zipCodeField = document.getElementById('zip_code');

    // ล้างค่า amphure, tambon และ zip code เมื่อเลือก province ใหม่
    amphureDropdown.innerHTML = '<option value="">Select Amphure</option>';
    tambonDropdown.innerHTML = '<option value="">Select Tambon</option>';
    zipCodeField.value = '';

    if (provinceId) {
        fetch(`/admin/amphures/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(function (amphure) {
                    var option = document.createElement('option');
                    option.value = amphure.id;
                    option.text = amphure.name_th;
                    amphureDropdown.appendChild(option);
                });
            });
    }
});

document.getElementById('amphure-dropdown').addEventListener('change', function () {
    var amphureId = this.value;
    var tambonDropdown = document.getElementById('tambon-dropdown');
    var zipCodeField = document.getElementById('zip_code');

    tambonDropdown.innerHTML = '<option value="">Select Tambon</option>';
    zipCodeField.value = '';

    if (amphureId) {
        fetch(`/admin/tambons/${amphureId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(function (tambon) {
                    var option = document.createElement('option');
                    option.value = tambon.id;
                    option.text = tambon.name_th;
                    tambonDropdown.appendChild(option);
                });
            });
    }
});

document.getElementById('tambon-dropdown').addEventListener('change', function () {
    var tambonId = this.value;

    if (tambonId) {
        fetch(`/admin/zipcode/${tambonId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('zip_code').value = data.zip_code;
            });
    }
});
