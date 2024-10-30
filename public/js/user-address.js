document.addEventListener("DOMContentLoaded", function () {
    let provinceDropdown = document.getElementById('province-dropdown');
    let amphureDropdown = document.getElementById('amphure-dropdown');
    let tambonDropdown = document.getElementById('tambon-dropdown');
    let zipCodeInput = document.querySelector('input[name="zip_code"]');

    // เมื่อเลือกจังหวัด ให้เรียก API ดึงอำเภอ
    provinceDropdown.addEventListener('change', function () {
        let provinceId = this.value;
        fetch(`/admin/amphures/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                amphureDropdown.innerHTML = ''; // ล้างค่าเก่าออก
                Object.keys(data).forEach(function (key) {
                    let option = document.createElement('option');
                    option.value = key;
                    option.textContent = data[key];
                    amphureDropdown.appendChild(option);
                });
                amphureDropdown.dispatchEvent(new Event('change')); // trigger change สำหรับอำเภอ
            });
    });

    // เมื่อเลือกอำเภอ ให้เรียก API ดึงตำบล
    amphureDropdown.addEventListener('change', function () {
        let amphureId = this.value;
        fetch(`/admin/tambons/${amphureId}`)
            .then(response => response.json())
            .then(data => {
                tambonDropdown.innerHTML = ''; // ล้างค่าเก่าออก
                Object.keys(data).forEach(function (key) {
                    let option = document.createElement('option');
                    option.value = key;
                    option.textContent = data[key];
                    tambonDropdown.appendChild(option);
                });
                tambonDropdown.dispatchEvent(new Event('change')); // trigger change สำหรับตำบล
            });
    });

    // เมื่อเลือกตำบล ให้เรียก API ดึงรหัสไปรษณีย์
    tambonDropdown.addEventListener('change', function () {
        let tambonId = this.value;
        fetch(`/admin/zipcode/${tambonId}`)
            .then(response => response.json())
            .then(data => {
                zipCodeInput.value = data.zip_code;
            });
    });
});